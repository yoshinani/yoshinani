<?php

namespace Infrastructure\DataSources\Database;

class Users extends Bass
{
    public function findUser($email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->first();

        return $result;
    }

    public function getUserId($email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->value('id');
        return $result;
    }

    public function setUser(array $userInfo)
    {
        $result = $this->db->table('users')
            ->insertGetId(
                [
                    'email' => $userInfo['email'],
                    'name'  => $userInfo['name'],
                ]
            );
        return $result;
    }
}