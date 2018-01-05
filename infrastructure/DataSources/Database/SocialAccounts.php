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
     * @param string $driverName
     * @return null|stdClass
     */
    public function getSocialAccount(int $socialUserId, string $driverName): ?stdClass
    {
        $result = $this->db->table('social_accounts')
            ->where('driver_name', $driverName)
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
                    'driver_name' => $registerSocialUserEntity->getDriverName(),
                    'social_user_id' => $registerSocialUserEntity->getSocialUserId(),
                    'created_at' => $registerSocialUserEntity->getCreatedAt(),
                    'updated_at' => $registerSocialUserEntity->getUpdatedAt(),
                ]
            );
    }
}
