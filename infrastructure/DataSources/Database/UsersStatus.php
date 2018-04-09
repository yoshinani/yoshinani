<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\Registers\UserEntity;

/**
 * Class UsersPassword
 * @package Infrastructure\DataSources\Database
 */
class UsersStatus extends Bass
{
    public function registerActive(UserEntity $registerUserEntity)
    {
        $this->db->table('users_status')
            ->insert(
                [
                    'user_id'    => $registerUserEntity->getId(),
                    'active'     => $registerUserEntity->getActive(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
    }
}
