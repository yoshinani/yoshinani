<?php

namespace Infrastructure\DataSources\Database;

/**
 * Class SocialAccounts
 * @package Infrastructure\DataSources\Database
 */
class SocialAccounts extends Bass
{
    /**
     * @param int $socialUserId
     * @param string $socialServiceName
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getSocialAccount(int $socialUserId, string $socialServiceName)
    {
        $result = $this->db->table('social_accounts')
            ->where('social_service_name', $socialServiceName)
            ->where('social_user_id', $socialUserId)
            ->first();

        return $result;
    }

    /**
     * @param array $socialUserEntity
     */
    public function setSocialAccount(array $socialUserEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'            => $socialUserEntity['id'],
                    'social_service_name'    => $socialUserEntity['socialServiceName'],
                    'social_user_id'   => $socialUserEntity['socialUserId'],
                    'social_user_name' => $socialUserEntity['socialUserName'],
                ]
            );
    }
}