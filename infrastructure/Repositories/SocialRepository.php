<?php

namespace Infrastructure\Repositories;

use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\DataSources\Database\SocialAccounts;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialRepository implements SocialRepositoryInterface
{
    private $socialAccounts;

    public function __construct(SocialAccounts $socialAccounts)
    {
        $this->socialAccounts = $socialAccounts;
    }

    public function findSocialAccount(ProviderUser $providerUser, $provider)
    {
        $providerUserId = $providerUser->getId();
        return $this->socialAccounts->getSocialAccount($providerUserId, $provider);
    }

    public function associationSocialAccount(ProviderUser $providerUser, $provider, $user)
    {
        $providerUserId = $providerUser->getId();
        $userId         = $user->id;
        $this->socialAccounts->setSocialAccount($providerUserId, $provider, $userId);
    }
}