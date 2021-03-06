<?php
namespace Domain\Services;

use Domain\Entities\UserEntity;
use Domain\Specification\ManualLoginSpecification;
use Domain\Specification\SocialLoginSpecification;
use Exception;
use Illuminate\Auth\AuthManager;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\Interfaces\UserRepositoryInterface;
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
    private $userRepository;

    /**
     * AuthService constructor.
     * @param AuthManager $authManager
     * @param ManualLoginSpecification $manualLoginSpecification
     * @param SocialLoginSpecification $socialLoginSpecification
     * @param SocialRepositoryInterface $socialRepository
     * @param SocialService $socialService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        AuthManager $authManager,
        ManualLoginSpecification $manualLoginSpecification,
        SocialLoginSpecification $socialLoginSpecification,
        SocialRepositoryInterface $socialRepository,
        SocialService $socialService,
        UserRepositoryInterface $userRepository
    ) {
        $this->authManager              = $authManager->guard('web');
        $this->manualLoginSpecification = $manualLoginSpecification;
        $this->socialLoginSpecification = $socialLoginSpecification;
        $this->socialRepository         = $socialRepository;
        $this->socialService            = $socialService;
        $this->userRepository           = $userRepository;
    }

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity
    {
        $userEntity = $this->userRepository->getUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $userEntity = $this->userRepository->registerUser($oldRequest);
            $password   = $this->userRepository->getUserPassword($userEntity->getId());
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
        $userEntity = $this->userRepository->getUser($socialUser->getEmail());
        if (is_null($userEntity)) {
            $userEntity = $this->socialRegisterUser($socialUser);
        }

        $socialUserAccountEntity = $this->socialRepository->getSocialAccounts($userEntity);
        if ($this->socialLoginSpecification->hasSocialAccount($socialUserAccountEntity, $driverName, $socialUser)) {
            $socialUserAccountEntity = $this->socialService->syncAccount($driverName, $socialUser, $userEntity);
        }

        $condition = $this->socialLoginSpecification->isCondition($driverName, $socialUser, $socialUserAccountEntity);
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

        return $this->userRepository->socialRegisterUser($socialUser);
    }

    /**
     * @return UserEntity
     */
    public function getLoginUser(): UserEntity
    {
        $userId = $this->authManager->id();

        return $this->userRepository->getLoginUser($userId);
    }

    /**
     * @param UserEntity $userEntity
     * @throws Exception
     */
    public function withdrawal(UserEntity $userEntity)
    {
        $this->userRepository->deleteUser($userEntity);
        $this->authManager->logout();
    }
}
