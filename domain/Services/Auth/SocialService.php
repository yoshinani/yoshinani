<?php

namespace Domain\Services\Auth;

use Exception;
use Domain\Specification\SocialLoginSpecification;
use Domain\Entities\{
    UserEntity,
    SocialUserAccountEntity
};
use Infrastructure\Interfaces\{
    AuthRepositoryInterface,
    SocialRepositoryInterface
};
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialService
 * @package Domain\Services\Auth
 */
class SocialService
{
    private $socialLoginSpecification;
    private $authRepository;
    private $socialRepository;

    /**
     * SocialService constructor.
     * @param SocialLoginSpecification $socialLoginSpecification
     * @param AuthRepositoryInterface $authRepository
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        SocialLoginSpecification $socialLoginSpecification,
        AuthRepositoryInterface $authRepository,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->socialLoginSpecification = $socialLoginSpecification;
        $this->authRepository = $authRepository;
        $this->socialRepository = $socialRepository;
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return bool
     * @throws Exception
     */
    public function socialLogin(string $driverName, SocialUser $socialUser): bool
    {
        $userEntity = $this->socialRegisterUser($driverName, $socialUser);
        $socialUserAccountEntity = $this->synchronizeSocialAccount($driverName, $socialUser);
        $userDetailEntity = $this->authRepository->getUserDetail($userEntity->getUserId());
        return $this->socialLoginSpecification->isCondition($driverName, $socialUser, $socialUserAccountEntity, $userDetailEntity);
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return UserEntity
     * @throws Exception
     */
    protected function socialRegisterUser(string $driverName, SocialUser $socialUser): UserEntity
    {
        $email = $socialUser->getEmail();
        $userEntity = $this->authRepository->findUser($email);
        if (is_null($userEntity)) {
            $this->socialLoginSpecification->isRequiredInfo($socialUser);
            $this->socialRepository->registerUser($driverName, $socialUser);
            $userEntity = $this->authRepository->findUser($email);
        }

        return $userEntity;
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return SocialUserAccountEntity
     */
    protected function synchronizeSocialAccount(string $driverName, SocialUser $socialUser): SocialUserAccountEntity
    {
        $userId = $this->socialRepository->getUserId($socialUser);
        $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $driverName, $socialUser);
        if (is_null($socialUserAccountEntity)) {
            $userId = $this->socialRepository->getUserId($socialUser);
            $this->socialRepository->synchronizeSocialAccount($userId, $driverName, $socialUser);
            $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $driverName, $socialUser);
        }
        return $socialUserAccountEntity;
    }

}
