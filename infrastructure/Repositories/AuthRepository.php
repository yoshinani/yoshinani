<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity,
    RegisterUserPasswordEntity,
    UserDetailEntity,
    UserEntity,
    UserPasswordEntity
};
use Infrastructure\DataSources\Database\{
    UsersPassword,
    Users
};
use Infrastructure\Interfaces\AuthRepositoryInterface;

/**
 * Class AuthRepository
 * @package Infrastructure\Repositories
 */
class AuthRepository implements AuthRepositoryInterface
{
    private $users;
    private $usersPassword;

    /**
     * {@inheritdoc}
     */
    public function __construct(Users $users, UsersPassword $usersPassword)
    {
        $this->users = $users;
        $this->usersPassword = $usersPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function findUser(string $email): ?UserEntity
    {
        $result = $this->users->findUser($email);
        if (is_null($result)) {
            return null;
        }
        $userRecord = (object)$result;
        return new UserEntity($userRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserPassword(int $userId): ?UserPasswordEntity
    {
        $result = $this->usersPassword->getUserPassword($userId);
        if (is_null($result)) {
            return null;
        }
        $userPasswordRecord = (object)$result;
        return new UserPasswordEntity($userId, $userPasswordRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId(array $oldRequest): ?int
    {
        $result = $this->users->getUserId($oldRequest['email']);
        if (is_null($result)) {
            return null;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserDetail(int $userId): ?UserDetailEntity
    {
        $result = $this->users->getUserDetail($userId);
        if (is_null($result)) {
            return null;
        }
        $userDetail = (object)$result;
        return new UserDetailEntity($userDetail);
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(array $oldRequest): int
    {
        $userRecord = (object)$oldRequest;
        $registerUserEntity = new RegisterUserEntity($userRecord);
        $userId = $this->users->registerUser($registerUserEntity);
        $registerUserPasswordEntity = new RegisterUserPasswordEntity($userId, $userRecord);
        $this->usersPassword->registerPassword($userId, $registerUserPasswordEntity);
        return $userId;
    }
}
