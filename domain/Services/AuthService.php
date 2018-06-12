<?php
namespace Domain\Services;

use Domain\Entities\UserEntity;
use Domain\Specification\ManualLoginSpecification;
use Domain\Specification\SocialLoginSpecification;
use Exception;
use Illuminate\Auth\AuthManager;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;
use Infrastructure\Interfaces\Auth\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class ManualService
 * @package Domain\Services\Auth
 */
class AuthService
{
    private $authManager;
    private $manualLoginSpecification;
    private $socialLoginSpecification;
    private $socialRepository;
    private $socialService;
    private $manualRepository;

    /**
     * AuthService constructor.
     * @param AuthManager $authManager
     * @param ManualLoginSpecification $manualLoginSpecification
     * @param SocialLoginSpecification $socialLoginSpecification
     * @param SocialRepositoryInterface $socialRepository
     * @param SocialService $socialService
     * @param ManualRepositoryInterface $manualRepository
     */
    public function __construct(
        AuthManager $authManager,
        ManualLoginSpecification $manualLoginSpecification,
        SocialLoginSpecification $socialLoginSpecification,
        SocialRepositoryInterface $socialRepository,
        SocialService $socialService,
        ManualRepositoryInterface $manualRepository
    ) {
        $this->authManager = $authManager->guard('web');
        $this->manualLoginSpecification = $manualLoginSpecification;
        $this->socialLoginSpecification = $socialLoginSpecification;
        $this->socialRepository         = $socialRepository;
        $this->socialService            = $socialService;
        $this->manualRepository         = $manualRepository;
    }

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity
    {
        $userEntity = $this->manualRepository->getUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $userEntity = $this->manualRepository->registerUser($oldRequest);
            $password   = $this->manualRepository->getUserPassword($userEntity->getId());
            $userEntity->setPassword($password);
        }

        return $userEntity;
    }

    /**
     * @param array $oldRequest
     * @param UserEntity $userEntity
     * @return bool
     */
    public function login(array $oldRequest, UserEntity $userEntity): bool
    {
        $condition = $this->manualLoginSpecification->isCondition($oldRequest, $userEntity);
        if ($condition) {
            $this->authManager->loginUsingId($userEntity->getId(), true);
        }
        return $condition;
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return bool
     * @throws Exception
     */
    public function socialLogin(string $driverName, SocialUser $socialUser): bool
    {
        $userEntity = $this->manualRepository->getUser($socialUser->getEmail());
        if (is_null($userEntity)) {
            $userEntity = $this->socialRegisterUser($socialUser);
        }

        $socialUserAccountEntity = $this->socialRepository->getSocialAccounts($userEntity);
        if ($this->socialLoginSpecification->hasSocialAccount($socialUserAccountEntity, $driverName, $socialUser)) {
            $socialUserAccountEntity = $this->socialService->syncAccount($driverName, $socialUser, $userEntity);
        }

        $condition = $this->socialLoginSpecification->isCondition($driverName, $socialUser, $socialUserAccountEntity, $userEntity);
        if ($condition) {
            $this->authManager->loginUsingId($socialUserAccountEntity->getId());
        }
        return $condition;
    }

    /**
     * @param SocialUser $socialUser
     * @return UserEntity
     * @throws Exception
     */
    protected function socialRegisterUser(SocialUser $socialUser): UserEntity
    {
        $this->socialLoginSpecification->isRequiredInfo($socialUser);

        return $this->socialRepository->registerUser($socialUser);
    }
}
