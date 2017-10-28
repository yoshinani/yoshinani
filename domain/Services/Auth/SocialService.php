<?php

namespace Domain\Services\Auth;

use DB;
use Auth;
use Exception;
use Laravel\Socialite\Contracts\User;
use App\Repositories\SocialRepositoryInterface;

class SocialService
{
    private $socialRepository;

    public function __construct(SocialRepositoryInterface $socialRepository)
    {
        $this->socialRepository = $socialRepository;
    }

    public function existsItems(User $providerUser)
    {
        if (is_null($providerUser->getName()) || is_null($providerUser->getEmail())) {
            throw new Exception('Name or email is missing');
        }
        return true;
    }

    public function findSocialAccount(User $providerUser, $provider)
    {
        $providerUserId = $providerUser->getId();

        return $this->socialRepository->findSocialAccount($providerUserId, $provider);
    }

    public function associationSocialAccount(User $providerUser, $provider, $user)
    {
        $providerUserId = $providerUser->getId();
        $userId         = $user->id;

        $this->socialRepository->associationSocialAccount($providerUserId, $provider, $userId);
    }

    public function socialLogin($user)
    {
        $auth = Auth::loginUsingId($user->id);
        if (!$auth) {
            throw new Exception('It is a User that does not exist');
        }
    }
}