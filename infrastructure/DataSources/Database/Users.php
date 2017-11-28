<?php

namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterUserEntity;

/**
 * Class Users
 * @package Infrastructure\DataSources\Database
 */
class Users extends Bass
{
    /**
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findUser(string $email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->first();
        return $result;
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getUserId(string $email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->value('id');
        return $result;
    }

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getUserDetail($userId)
    {
        $result = $this->db->table('users')
            ->join('users_password', 'users_password.user_id', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('users.id', 'users.name', 'users.email', 'users_password.password')
            ->first();
        return $result;
    }

    /**
     * @param RegisterUserEntity $registerUserEntity
     * @return int
     */
    public function registerUser(RegisterUserEntity $registerUserEntity)
    {
        $result = $this->db->table('users')
            ->insertGetId(
                [
                    'email' => $registerUserEntity->getEmail(),
                    'name' => $registerUserEntity->getName(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );
        return $result;
    }
}
