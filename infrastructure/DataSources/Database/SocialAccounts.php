<?php

namespace Infrastructure\DataSources\Database;

class SocialAccounts extends Bass
{
    public function getSocialAccount(string $provider, int $socialUserId)
    {
        $result = $this->db->table('social_accounts')
            ->where('provider_name', $provider)
            ->where('provider_user_id', $socialUserId)
            ->first();

        return $result;
    }

    public function setSocialAccount(array $socialUserEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'            => $socialUserEntity['id'],
                    'provider_name'      => $socialUserEntity['socialServiceName'],
                    'provider_user_id'   => $socialUserEntity['socialUserId'],
                    'provider_user_name' => $socialUserEntity['socialUserName'],
                ]
            );
    }
}