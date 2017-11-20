<?php

namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterUserEntity;
use Exception;
use stdClass;

/**
 * Class Users
 * @package Infrastructure\DataSources\Database
 */
class Users extends Bass
{
    /**
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws Exception
     */
    public function findUser(string $email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->first();
        if (is_null($result)) {
            throw new Exception('User does not exist');
        }
        return $result;
    }

    /**
     * @param string $email
     * @return mixed
     * @throws Exception
     */
    public function getUserId(string $email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->value('id');
        if (is_null($result)) {
            throw new Exception('User ID does not exist');
        }
        return $result;
    }

    /**
     * @param RegisterUserEntity $registerUserEntity
     * @internal param string $userEmail
     * @internal param string $userName
     */
    public function registerUser(RegisterUserEntity $registerUserEntity)
    {
        $this->db->table('users')
            ->insert(
                [
                    'email' => $registerUserEntity->getEmail(),
                    'name' => $registerUserEntity->getName(),
                    'password' => $registerUserEntity->getPassword(),
                ]
            );
    }
}
