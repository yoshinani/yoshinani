<?php

namespace Infrastructure\DataSources\Database;

class SocialAccounts extends Bass
{
    public function getSocialAccount(int $providerUserId, string $providerUserName)
    {
        $result = $this->db->table('social_accounts')
            ->where('provider_name', $providerUserName)
            ->where('provider_id', $providerUserId)
            ->first();

        return $result;
    }

    public function setSocialAccount(array $providerUserEntity, array $userEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'       => $userEntity['id'],
                    'provider_id'   => $providerUserEntity['id'],
                    'provider_name' => $providerUserEntity['name'],
                ]
            );
    }
}