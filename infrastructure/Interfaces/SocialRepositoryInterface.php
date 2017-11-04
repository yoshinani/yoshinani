<?php

namespace Infrastructure\Interfaces;

use Domain\ValueObjects\UserValueObject;
use Laravel\Socialite\Contracts\User as ProviderUser;

interface SocialRepositoryInterface
{
    public function findSocialAccount(ProviderUser $providerUser, $provider);
    public function findUser(ProviderUser $providerUser);
    public function getUserId(ProviderUser $providerUser);
    public function registerUser(ProviderUser $providerUser, string $provider);
    public function associationSocialAccount(ProviderUser $providerUser, $provider, UserValueObject $userValueObject, int $userId);
}