<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\Registers\UserNickNameEntity;
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
     * @param int $userId
     * @param UserNickNameEntity $registerUserNickNameEntity
     */
    public function registerNickName(int $userId, UserNickNameEntity $registerUserNickNameEntity)
    {
        $this->db->table('users_nickname')
            ->insert(
                [
                    'user_id'    => $userId,
                    'nickname'   => $registerUserNickNameEntity->getNickName(),
                    'created_at' => $registerUserNickNameEntity->getCreatedAt(),
                    'updated_at' => $registerUserNickNameEntity->getUpdatedAt(),
                ]
            );
    }
}
