<?php

namespace Infrastructure\DataSources\Database;

class Users extends Bass
{
    public function getUser($providerUserEmail)
    {
        $result = $this->db->table('users')
            ->where('email', $providerUserEmail)
            ->first();

        return $result;
    }

    public function setUser($providerUserEmail, $providerUserName)
    {
        $this->db->table('users')
            ->insert(
                [
                    'email' => $providerUserEmail,
                    'name'  => $providerUserName,
                ]
            );
    }
}