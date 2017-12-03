<?php

namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterSocialUserEntity;
use stdClass;

/**
 * Class SocialAccounts
 * @package Infrastructure\DataSources\Database
 */
class SocialAccounts extends Bass
{
    /**
     * @param int $socialUserId
     * @param string $socialServiceName
     * @return null|stdClass
     */
    public function getSocialAccount(int $socialUserId, string $socialServiceName): ?stdClass
    {
        $result = $this->db->table('social_accounts')
            ->where('social_service_name', $socialServiceName)
            ->where('social_user_id', $socialUserId)
            ->first();

        return $result;
    }

    /**
     * @param RegisterSocialUserEntity $registerSocialUserEntity
     */
    public function registerSocialAccount(RegisterSocialUserEntity $registerSocialUserEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id' => $registerSocialUserEntity->getId(),
                    'social_service_name' => $registerSocialUserEntity->getSocialServiceName(),
                    'social_user_id' => $registerSocialUserEntity->getSocialUserId(),
                    'created_at' => $registerSocialUserEntity->getCreatedAt(),
                    'updated_at' => $registerSocialUserEntity->getUpdatedAt(),
                ]
            );
    }
}
