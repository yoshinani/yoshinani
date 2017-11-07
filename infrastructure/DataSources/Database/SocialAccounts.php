<?php

namespace Infrastructure\DataSources\Database;

class SocialAccounts extends Bass
{
    public function getSocialAccount(string $provider, int $providerUserId)
    {
        $result = $this->db->table('social_accounts')
            ->where('provider_name', $provider)
            ->where('provider_user_id', $providerUserId)
            ->first();

        return $result;
    }

    public function setSocialAccount(array $providerUserEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'            => $providerUserEntity['id'],
                    'provider_name'      => $providerUserEntity['providerName'],
                    'provider_user_id'   => $providerUserEntity['providerUserId'],
                    'provider_user_name' => $providerUserEntity['providerUserName'],
                ]
            );
    }
}