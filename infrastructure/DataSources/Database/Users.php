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
            ->leftJoin('users_nickname', 'users_nickname.user_id', '=', 'users.id')
            ->leftjoin('users_password', 'users_password.user_id', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('users.id', 'users.email', 'users.name', 'users_nickname.nickname', 'users_password.password')
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
            ->leftJoin('users_nickname', 'users_nickname.user_id', '=', 'users.id')
            ->leftjoin('users_password', 'users_password.user_id', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('users.id', 'users.email', 'users.name', 'users_nickname.nickname', 'users_password.password')
            ->first();

        return $result;
    }

    /**
     * @param UserEntity $userEntity
     * @return int
     */
    public function registerUser(UserEntity $userEntity): int
    {
        $result = $this->db->table('users')
            ->insertGetId(
                [
                    'email'      => $userEntity->getEmail(),
                    'name'       => $userEntity->getName(),
                    'created_at' => $userEntity->getCreatedAt(),
                    'updated_at' => $userEntity->getUpdatedAt(),
                ]
            );

        return $result;
    }

    /**
     * @param UserEntity $userEntity
     * @return int
     */
    public function registerDeleteUser(UserEntity $userEntity): int
    {
        $result = $this->db->table('deleted_users')
            ->insert(
                [
                    'user_id'    => $userEntity->getId(),
                    'email'      => $userEntity->getEmail(),
                    'name'       => $userEntity->getName(),
                    'created_at' => $userEntity->getCreatedAt(),
                    'updated_at' => $userEntity->getUpdatedAt(),
                ]
            );

        return $result;
    }

    /**
     * @param UserEntity $userEntity
     */
    public function deleteUser(UserEntity $userEntity)
    {
        $this->db->table('users')
            ->where('id', $userEntity->getId())
            ->update(
                [
                    'email'      => null,
                    'updated_at' => $userEntity->getUpdatedAt(),
                ]
            );
    }
}
