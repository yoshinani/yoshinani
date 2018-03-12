<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterUserEntity;

/**
 * Class UsersPassword
 * @package Infrastructure\DataSources\Database
 */
class UsersStatus extends Bass
{
    public function registerActive(int $userId, RegisterUserEntity $registerUserEntity)
    {
        $this->db->table('users_status')
            ->insert(
                [
                    'user_id'    => $userId,
                    'active'     => $registerUserEntity->getActive(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
    }
}
