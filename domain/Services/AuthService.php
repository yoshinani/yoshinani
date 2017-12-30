<?php

namespace Domain\Services;

use Auth;
use Exception;
use Domain\Entities\{
    UserEntity,
    UserDetailEntity,
    SocialUserAccountEntity
};
use Infrastructure\Interfaces\{
    AuthRepositoryInterface,
    SocialRepositoryInterface
};
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class AuthService
 * @package Domain\Services
 */
class AuthService
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
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity
    {
        $userEntity = $this->authRepository->findUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $this->authRepository->registerUser($oldRequest);
            $userEntity = $this->authRepository->findUser($oldRequest['email']);
        }

        return $userEntity;
    }

    /**
     * @param array $oldRequest
     * @return UserDetailEntity
     * @throws Exception
     */
    public function getUserDetail(array $oldRequest): UserDetailEntity
    {
        $userId = $this->authRepository->getUserId($oldRequest);
        if (is_null($userId)) {
            throw new Exception('User does not exist');
        }
        return $this->authRepository->getUserDetail($userId);
    }

    /**
     * @param array $oldRequest
     * @param int $userId
     * @return bool
     */
    public function login(array $oldRequest, int $userId): bool
    {
        $userDetailEntity = $this->authRepository->getUserDetail($userId);

        if ($oldRequest['email'] !== $userDetailEntity->getUserEmail()) {
            \Log::info("\n【ERROR】Email does not match\n"
                .'Email:'.$oldRequest['email']
                .'Password:'.encrypt($oldRequest['password'])
            );
            \Log::info($oldRequest['email'].' does not match');
            return false;
        }

        if ($oldRequest['password'] !== $userDetailEntity->getPassword()) {
            \Log::info("\n【ERROR】Password does not match\n"
                .'Email:'.$oldRequest['email']
                .'Password:'.encrypt($oldRequest['password'])
            );
            return false;
        }

        // TODO: deleted_at is null ?

        if (!Auth::loginUsingId($userDetailEntity->getUserId(), true)) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                .'Email:'.$oldRequest['email']
                .'Password:'.encrypt($oldRequest['password'])
            );
            return false;
        }

        return true;
    }

    /**
     * @param SocialUser $socialUser
     * @return UserEntity
     * @throws Exception
     */
    public function socialRegisterUser(SocialUser $socialUser): UserEntity
    {
        $userEntity = $this->socialRepository->findUser($socialUser);
        if (is_null($userEntity)) {
            $this->hasSocialRequiredInformation($socialUser);
            $this->socialRepository->registerUser($socialUser);
            $userEntity = $this->socialRepository->findUser($socialUser);
        }

        return $userEntity;
    }

    /**
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return bool
     */
    public function socialLogin(string $socialServiceName, SocialUser $socialUser): bool
    {
        $socialUserAccountEntity = $this->synchronizeSocialAccount($socialServiceName, $socialUser);

        if ($socialUserAccountEntity->getSocialServiceName() != $socialServiceName) {
            \Log::info("\n【ERROR】Authentication drivers do not match\n"
                .'Entity:'.$socialUserAccountEntity->getSocialServiceName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$socialServiceName.':'.$socialUser->getId()
            );
            return false;
        }

        if ($socialUserAccountEntity->getSocialUserId() != $socialUser->getId()) {
            \Log::info("\n【ERROR】It does not match the ID of SNS Account\n"
                .'Entity:'.$socialUserAccountEntity->getSocialServiceName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$socialServiceName.':'.$socialUser->getId()
            );
            return false;
        }

        if (!Auth::loginUsingId($socialUserAccountEntity->getId())) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                .'Entity:'.$socialUserAccountEntity->getSocialServiceName().':'.$socialUserAccountEntity->getSocialUserId()."\n"
                .'Request:'.$socialServiceName.':'.$socialUser->getId()
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
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return SocialUserAccountEntity
     */
    protected function synchronizeSocialAccount(string $socialServiceName, SocialUser $socialUser): SocialUserAccountEntity
    {
        $userId = $this->socialRepository->getUserId($socialUser);
        $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $socialServiceName, $socialUser);
        if (is_null($socialUserAccountEntity)) {
            $userId = $this->socialRepository->getUserId($socialUser);
            $this->socialRepository->synchronizeSocialAccount($userId, $socialServiceName, $socialUser);
            $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $socialServiceName, $socialUser);
        }
        return $socialUserAccountEntity;
    }

}
