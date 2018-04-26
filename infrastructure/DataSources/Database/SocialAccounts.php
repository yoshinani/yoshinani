<?php
namespace Infrastructure\DataSources\Database;

use Laravel\Socialite\Contracts\User as SocialUser;
use Domain\Entities\SocialUserEntity;
use stdClass;

/**
 * Class SocialAccounts
 * @package Infrastructure\DataSources\Database
 */
class SocialAccounts extends Bass
{
    /**
     * @param SocialUser $socialUser
     * @param string $driverName
     * @return null|stdClass
     */
    public function getSocialAccount(SocialUser $socialUser, string $driverName): ?stdClass
    {
        $result = $this->db->table('social_accounts')
            ->where('driver_name', $driverName)
            ->where('social_user_id', $socialUser->getId())
            ->first();

        return $result;
    }

    /**
     * @param SocialUserEntity $registerSocialUserEntity
     */
    public function registerSocialAccount(SocialUserEntity $registerSocialUserEntity)
    {
        $this->db->table('social_accounts')
            ->insert(
                [
                    'user_id'        => $registerSocialUserEntity->getId(),
                    'driver_name'    => $registerSocialUserEntity->getDriverName(),
                    'social_user_id' => $registerSocialUserEntity->getSocialUserId(),
                    'created_at'     => $registerSocialUserEntity->getCreatedAt(),
                    'updated_at'     => $registerSocialUserEntity->getUpdatedAt(),
                ]
            );
    }
}
