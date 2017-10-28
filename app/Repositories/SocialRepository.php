<?php

namespace App\Repositories;

use DB;

class SocialRepository implements SocialRepositoryInterface
{

    public function findSocialAccount($providerUserId, $provider)
    {
        $result = DB::table('social_accounts')
            ->where('provider_name', $provider)
            ->where('provider_id', $providerUserId)
            ->first();
        return $result;
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