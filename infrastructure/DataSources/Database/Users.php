<?php

namespace Infrastructure\DataSources\Database;

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
     * @param string $userEmail
     * @param string $userName
     * @return int
     */
    public function setUser(string $userEmail, string $userName)
    {
        $result = $this->db->table('users')
            ->insertGetId(
                [
                    'email' => $userEmail,
                    'name'  => $userName,
                ]
            );
        return $result;
    }
}