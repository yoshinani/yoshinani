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
        DB::table('social_accounts')->insert(
            [
                'user_id'       => $userId,
                'provider_id'   => $providerUserId,
                'provider_name' => $provider,
            ]
        );
    }
}