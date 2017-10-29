<?php

namespace Infrastructure\DataSources\Database;

class SocialAccounts extends Bass
{
    public function getSocialAccount($providerUserId, $provider)
    {
        $result = $this->db->table('social_accounts')
            ->where('provider_name', $provider)
            ->where('provider_id', $providerUserId)
            ->first();

        return $result;
    }

    public function setSocialAccount($providerUserId, $provider, $userId)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'       => $userId,
                    'provider_id'   => $providerUserId,
                    'provider_name' => $provider,
                ]
            );
    }
}