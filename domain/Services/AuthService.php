<?php

namespace Domain\Services;

use Auth;
use Exception;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class AuthService
 * @package Domain\Services
 */
class AuthService
{
    private $socialRepository;

    /**
     * AuthService constructor.
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        SocialRepositoryInterface $socialRepository
    ) {
        $this->socialRepository = $socialRepository;
    }

    /**
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @throws Exception
     */
    public function socialLogin(string $socialServiceName, SocialUser $socialUser)
    {
        $userEntity = $this->socialRepository->findUser($socialUser);
        if (is_null($userEntity)) {
            $this->socialRepository->registerUser($socialUser);
        }

        $userId = $this->socialRepository->getUserId($socialUser);
        $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $socialServiceName, $socialUser);
        if (is_null($socialUserAccountEntity)) {
            $userId = $this->socialRepository->getUserId($socialUser);
            $this->socialRepository->associationSocialAccount($userId, $socialServiceName, $socialUser);
            $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userId, $socialServiceName, $socialUser);
        }

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
}
