<?php
namespace Domain\Services\Auth;

use Exception;
use Domain\Specification\SocialLoginSpecification;
use Domain\Entities\UserEntity;
use Domain\Entities\SocialUserAccountEntity;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;
use Infrastructure\Interfaces\Auth\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialService
 * @package Domain\Services\Auth
 */
class SocialService
{
    private $socialLoginSpecification;
    private $manualRepository;
    private $socialRepository;

    /**
     * SocialService constructor.
     * @param SocialLoginSpecification $socialLoginSpecification
     * @param ManualRepositoryInterface $manualRepository
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        SocialLoginSpecification $socialLoginSpecification,
        ManualRepositoryInterface $manualRepository,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->socialLoginSpecification = $socialLoginSpecification;
        $this->manualRepository         = $manualRepository;
        $this->socialRepository         = $socialRepository;
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

        $socialUserAccountEntity = $this->socialRepository->getSocialAccount($userEntity);
        if ($this->socialLoginSpecification->hasSocialAccount($socialUserAccountEntity, $driverName, $socialUser)) {
            $socialUserAccountEntity = $this->syncAccount($driverName, $socialUser, $userEntity);
        }

        return $this->socialLoginSpecification->isCondition($driverName, $socialUser, $socialUserAccountEntity, $userEntity);
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

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @param UserEntity $userEntity
     * @return SocialUserAccountEntity
     */
    protected function syncAccount(string $driverName, SocialUser $socialUser, UserEntity $userEntity): SocialUserAccountEntity
    {
        $this->socialRepository->syncAccount($userEntity, $driverName, $socialUser);

        return $this->socialRepository->getSocialAccount($userEntity);
    }
}
