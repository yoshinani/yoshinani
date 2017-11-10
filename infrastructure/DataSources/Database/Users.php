<?php

namespace Infrastructure\DataSources\Database;

class Users extends Bass
{
    public function findUser(string $email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->first();

        return $result;
    }

    public function getUserId(string $email)
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->value('id');
        return $result;
    }

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