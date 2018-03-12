<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\RegisterUserEntity;
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
     * @return int|null
     */
    public function getUserId(string $email): ?int
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->value('id');

        return $result;
    }

    /**
     * @param $userId
     * @return null|stdClass
     */
    public function getUserDetail($userId): ?stdClass
    {
        $result = $this->db->table('users')
            ->join('users_status', 'users_status.user_id', '=', 'users.id')
            ->leftJoin('users_nickname', 'users_nickname.user_id', '=', 'users.id')
            ->leftjoin('users_password', 'users_password.user_id', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('users.id', 'users.email', 'users.name', 'users_nickname.nickname', 'users_password.password', 'users_status.active')
            ->first();

        return $result;
    }

    /**
     * @param RegisterUserEntity $registerUserEntity
     * @return int
     */
    public function registerUser(RegisterUserEntity $registerUserEntity): int
    {
        $result = $this->db->table('users')
            ->insertGetId(
                [
                    'email'      => $registerUserEntity->getEmail(),
                    'name'       => $registerUserEntity->getName(),
                    'created_at' => $registerUserEntity->getCreatedAt(),
                    'updated_at' => $registerUserEntity->getUpdatedAt(),
                ]
            );

        return $result;
    }
}
