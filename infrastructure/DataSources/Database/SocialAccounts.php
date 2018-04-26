<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\UserEntity;
use Domain\Entities\SocialUserEntity;
use Illuminate\Support\Collection;

/**
 * Class SocialAccounts
 * @package Infrastructure\DataSources\Database
 */
class SocialAccounts extends Bass
{
    /**
     * @param UserEntity $userEntity
     * @return Collection
     */
    public function getSocialAccount(UserEntity $userEntity): Collection
    {
        $result = $this->db->table('social_accounts')
            ->where('user_id', $userEntity->getId())
            ->get();

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
