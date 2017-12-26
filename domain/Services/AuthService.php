<?php

namespace Domain\Services;

use Auth;
use Exception;
use Domain\Entities\{
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
     * @return UserDetailEntity
     */
    public function registerUser(array $oldRequest): UserDetailEntity
    {
        $userId = $this->authRepository->registerUser($oldRequest);
        return $this->authRepository->getUserDetail($userId);
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
     * @param UserDetailEntity $userDetailEntity
     * @return bool
     */
    public function login(array $oldRequest, UserDetailEntity $userDetailEntity): bool
    {
        if ($oldRequest['email'] !== $userDetailEntity->getUserEmail()) {
            \Log::info($oldRequest['email'].' does not match');
            return false;
        }

        if ($oldRequest['password'] !== $userDetailEntity->getPassword()) {
            \Log::info('The password of '.$oldRequest['email'].' does not match');
            return false;
        }

        // TODO: deleted_at is null ?

        if (!Auth::loginUsingId($userDetailEntity->getUserId(), true)) {
            \Log::info($oldRequest['email'].' failed to login');
            return false;
        }

        return true;
    }

    /**
     * @param SocialUser $socialUser
     * @throws Exception
     */
    public function socialRegisterUser(SocialUser $socialUser)
    {
        $userEntity = $this->socialRepository->findUser($socialUser);
        if (is_null($userEntity)) {
            $this->hasSocialRequiredInformation($socialUser);
            $this->socialRepository->registerUser($socialUser);
        }
    }

    /**
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @throws Exception
     */
    public function socialLogin(string $socialServiceName, SocialUser $socialUser)
    {
        $socialUserAccountEntity = $this->synchronizeSocialAccount($socialServiceName, $socialUser);

        if (!$socialUserAccountEntity->getSocialServiceName() === $socialServiceName) {
            throw new Exception('Authentication drivers do not match');
        }

        if (!$socialUserAccountEntity->getSocialUserId() === $socialUser->getId()) {
            throw new Exception('It does not match the ID of SNSAccount');
        }

        if (!Auth::loginUsingId($socialUserAccountEntity->getId())) {
            throw new Exception('It is a User that does not exist');
        }
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
