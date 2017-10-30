<?php

namespace Infrastructure\Interfaces;

use Laravel\Socialite\Contracts\User as ProviderUser;

interface SocialRepositoryInterface
{
    public function findSocialAccount(ProviderUser $providerUser, $provider);
    public function associationSocialAccount(ProviderUser $providerUser, $provider, $user);
}