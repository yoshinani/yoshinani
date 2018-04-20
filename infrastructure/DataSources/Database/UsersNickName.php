<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\UserEntity;
use stdClass;

/**
 * Class UsersPassword
 * @package Infrastructure\DataSources\Database
 */
class UsersNickName extends Bass
{
    /**
     * @param int $userId
     * @return stdClass|null
     */
    public function getUserNickName(int $userId): ?stdClass
    {
        $result = $this->db->table('users_nickname')
            ->where('user_id', $userId)
            ->first();

        return $result;
    }

    /**
     * @param UserEntity $registerUserEntity
     */
    public function registerNickName(UserEntity $registerUserEntity)
    {
        $this->db->table('users_nickname')
            ->insert(
                [
                    'user_id'    => $registerUserEntity->getId(),
                    'nickname'   => $registerUserEntity->getNickName(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
    }
}
