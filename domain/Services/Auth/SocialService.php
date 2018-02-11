<?php

namespace Domain\Services\Auth;

use Auth;
use Exception;
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
    private $authRepository;
    private $socialRepository;

    /**
     * AuthService constructor.
     * @param AuthRepositoryInterface $authRepository
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        AuthRepositoryInterface $authRepository,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->authRepository = $authRepository;
        $this->socialRepository = $socialRepository;
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
            $this->hasSocialRequiredInformation($socialUser);
            $this->socialRepository->registerUser($driverName, $socialUser);
            $userEntity = $this->authRepository->findUser($email);
        }

        return $userEntity;
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

        if ($socialUserAccountEntity->getDriverName() != $driverName) {
            \Log::info("\n【ERROR】Authentication drivers do not match\n"
                .'Entity:'.$socialUserAccountEntity->getDriverName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$driverName.':'.$socialUser->getId()
            );
            return false;
        }

        if ($socialUserAccountEntity->getSocialUserId() != $socialUser->getId()) {
            \Log::info("\n【ERROR】It does not match the ID of SNS Account\n"
                .'Entity:'.$socialUserAccountEntity->getDriverName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$driverName.':'.$socialUser->getId()
            );
            return false;
        }

        if (!$userDetailEntity->getActiveStatus()) {
            \Log::info("\n【ERROR】Not a living user\n"
                .'Entity:'.$socialUserAccountEntity->getDriverName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$driverName.':'.$socialUser->getId()
            );
            return false;
        }

        if (!Auth::loginUsingId($socialUserAccountEntity->getId())) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                .'Entity:'.$socialUserAccountEntity->getDriverName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$driverName.':'.$socialUser->getId()
            );
            return false;
        }

        return true;
    }

    /**
     * @param SocialUser $socialUser
     * @throws Exception
     */
    protected function hasSocialRequiredInformation(SocialUser $socialUser)
    {
        if (is_null($socialUser->getEmail())) {
            throw new Exception('Email is missing');
        }

        if (is_null($socialUser->getName())) {
            throw new Exception('Name is missing');
        }

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
