<?php

namespace Infrastructure\Repositories;

use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\DataSources\Database\SocialAccounts;

class SocialRepository implements SocialRepositoryInterface
{
    private $socialAccounts;

    public function __construct(SocialAccounts $socialAccounts)
    {
        $this->socialAccounts = $socialAccounts;
    }

    public function findSocialAccount($providerUserId, $provider)
    {
        return $this->socialAccounts->getSocialAccount($providerUserId, $provider);
    }

    public function associationSocialAccount($providerUserId, $provider, $userId)
    {
        $this->socialAccounts->setSocialAccount($providerUserId, $provider, $userId);
    }
}