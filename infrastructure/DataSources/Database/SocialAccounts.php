<?php

namespace Infrastructure\DataSources\Database;

class SocialAccounts extends Bass
{
    public function getSocialAccount(string $socialServiceName, int $socialUserId)
    {
        $result = $this->db->table('social_accounts')
            ->where('social_service_name', $socialServiceName)
            ->where('social_user_id', $socialUserId)
            ->first();

        return $result;
    }

    public function setSocialAccount(array $socialUserEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'            => $socialUserEntity['id'],
                    'social_service_name'      => $socialUserEntity['socialServiceName'],
                    'social_user_id'   => $socialUserEntity['socialUserId'],
                    'social_user_name' => $socialUserEntity['socialUserName'],
                ]
            );
    }
}