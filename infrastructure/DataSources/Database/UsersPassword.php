<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\Registers\UserPasswordEntity;
use stdClass;

/**
 * Class UsersPassword
 * @package Infrastructure\DataSources\Database
 */
class UsersPassword extends Bass
{
    /**
     * @param int $userId
     * @return stdClass|null
     */
    public function getUserPassword(int $userId): ?stdClass
    {
        $result = $this->db->table('users_password')
            ->where('user_id', $userId)
            ->first();

        return $result;
    }

    /**
     * @param int $userId
     * @param UserPasswordEntity $registerUserPasswordEntity
     */
    public function registerPassword(int $userId, UserPasswordEntity $registerUserPasswordEntity)
    {
        $this->db->table('users_password')
            ->insert(
                [
                    'user_id'    => $userId,
                    'password'   => $registerUserPasswordEntity->getPassword(),
                    'created_at' => $registerUserPasswordEntity->getCreatedAt(),
                    'updated_at' => $registerUserPasswordEntity->getUpdatedAt(),
                ]
            );
    }
}
