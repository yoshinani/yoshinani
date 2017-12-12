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
     * @throws Exception
     */
    public function login(array $oldRequest, UserDetailEntity $userDetailEntity)
    {
        if (!$oldRequest['email'] === $userDetailEntity->getUserEmail()) {
            throw new Exception('email does not match');
        }

        if (!$oldRequest['password'] === $userDetailEntity->getPassword()) {
            throw new Exception('password does not match');
        }

        if (!Auth::loginUsingId($userDetailEntity->getUserId(), true)) {
            throw new Exception('It is a User that does not exist');
        }
    }

    /**
     * @param SocialUser $socialUser
     * @throws Exception
     */
    public function socialRegisterUser(SocialUser $socialUser)
    {
        $hasEmail = $this->hasSocialEmail($socialUser);
        $hasUserName = $this->hasSocialUserName($socialUser);
        if ($hasEmail === false || $hasUserName === false) {
            throw new Exception('Name or Email is missing');
        }

        $userEntity = $this->socialRepository->findUser($socialUser);
        if (is_null($userEntity)) {
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
     * @return bool
     */
    protected function hasSocialEmail(SocialUser $socialUser): bool
    {
        if (is_null($socialUser->getEmail())) {
            return false;
        }
        return true;
    }

    /**
     * @param SocialUser $socialUser
     * @return bool
     */
    protected function hasSocialUserName(SocialUser $socialUser): bool
    {
        if (is_null($socialUser->getName())) {
            return false;
        }
        return true;
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
            $this->socialRepository->associationSocialAccount($userId, $socialServiceName, $socialUser);
            $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $socialServiceName, $socialUser);
        }
        return $socialUserAccountEntity;
    }

}
