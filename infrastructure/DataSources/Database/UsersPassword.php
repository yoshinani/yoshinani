<?php

namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterUserPasswordEntity;

/**
 * Class UsersPassword
 * @package Infrastructure\DataSources\Database
 */
class UsersPassword extends Bass
{
    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getUserPassword(int $userId)
    {
        $result = $this->db->table('users_password')
            ->where('user_id', $userId)
            ->first();
        return $result;
    }

    /**
     * @param int $userId
     * @param RegisterUserPasswordEntity $registerUserPasswordEntity
     */
    public function registerPassword(int $userId, RegisterUserPasswordEntity $registerUserPasswordEntity)
    {
        $this->db->table('users_password')
            ->insert(
                [
                    'user_id' => $userId,
                    'password' => $registerUserPasswordEntity->getPassword(),
                    'created_at' => $registerUserPasswordEntity->getCreatedAt(),
                    'updated_at' => $registerUserPasswordEntity->getUpdatedAt(),
                ]
            );
    }
}
