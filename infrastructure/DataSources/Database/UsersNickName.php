<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
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
     * @param RegisterUserEntity $registerUserEntity
     */
    public function registerNickName(int $userId, RegisterUserEntity $registerUserEntity)
    {
        $this->db->table('users_nickname')
            ->insert(
                [
                    'user_id'    => $userId,
                    'nickname'   => $registerUserEntity->getNickName(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
    }
}
