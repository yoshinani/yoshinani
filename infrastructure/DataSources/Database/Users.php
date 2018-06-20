<?php
namespace Infrastructure\DataSources\Database;

use Domain\Entities\UserEntity;
use stdClass;

/**
 * Class Users
 * @package Infrastructure\DataSources\Database
 */
class Users extends Bass
{
    /**
     * @param string $email
     * @return int|null
     */
    protected function getUserId(string $email): ?int
    {
        $result = $this->db->table('users')
            ->where('email', $email)
            ->value('id');

        return $result;
    }

    /**
     * @param string $email
     * @return null|stdClass
     */
    public function getUser(string $email): ?stdClass
    {
        $userId = $this->getUserId($email);
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
     * @param int $userId
     * @return null|stdClass
     */
    public function getLoginUser(int $userId): ?stdClass
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
     * @param UserEntity $registerUserEntity
     * @return int
     */
    public function registerUser(UserEntity $registerUserEntity): int
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
