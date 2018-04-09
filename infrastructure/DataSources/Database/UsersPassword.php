<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
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
     * @param RegisterUserEntity $registerUserEntity
     */
    public function registerPassword(RegisterUserEntity $registerUserEntity)
    {
        $this->db->table('users_password')
            ->insert(
                [
                    'user_id'    => $registerUserEntity->getId(),
                    'password'   => $registerUserEntity->getPassword(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
    }
}
