<?php

namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterUserEntity;

/**
 * Class UsersName
 * @package Infrastructure\DataSources\Database
 */
class UsersName extends Bass
{
    /**
     * @param int $userId
     * @param RegisterUserEntity $registerUserEntity
     */
    public function registerUserName(int $userId, RegisterUserEntity $registerUserEntity)
    {
        $this->db->table('users_name')
            ->insert(
                [
                    'user_id' => $userId,
                    'nickname' => $registerUserEntity->getNickName(),
                    'name' => $registerUserEntity->getName(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
    }
}
