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
     * @param RegisterUserEntity $registerUserEntity
     * @internal param string $userEmail
     * @internal param string $userName
     * @return int
     */
    public function setUser(RegisterUserEntity $registerUserEntity)
    {
        $result = $this->db->table('users')
            ->insert(
                [
                    'email' => $registerUserEntity->getEmail(),
                    'name' => $registerUserEntity->getName(),
                    'password' => $registerUserEntity->getPassword(),
                ]
            );
        return $result;
    }
}
