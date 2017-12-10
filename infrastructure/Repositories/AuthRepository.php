<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity,
    RegisterUserPasswordEntity,
    UserDetailEntity,
    UserEntity,
    UserPasswordEntity
};
use Domain\ValueObjects\{
    PasswordValueObject,
    UserValueObject
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
    public function findUser(array $oldRequest): ?UserEntity
    {
        $userRequestObject = (object)$oldRequest;
        $result = $this->users->findUser($userRequestObject->email);
        if (is_null($result)) {
            return null;
        }
        $userRecord = (object)$result;
        $userValueObject = new UserValueObject($userRecord);
        return new UserEntity($userRecord, $userValueObject);
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
        $passwordValueObject = new PasswordValueObject($userPasswordRecord);
        return new UserPasswordEntity($userId, $passwordValueObject);
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
        $userValueObject = new UserValueObject($userDetail);
        $passwordValueObject = new PasswordValueObject($userDetail);
        return new UserDetailEntity($userDetail, $userValueObject, $passwordValueObject);
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(array $oldRequest): int
    {
        $userRecord = (object)$oldRequest;
        $userValueObject = new UserValueObject($userRecord);
        $registerUserEntity = new RegisterUserEntity($userRecord, $userValueObject);
        $userId = $this->users->registerUser($registerUserEntity);
        $passwordValueObject = new PasswordValueObject($userRecord);
        $registerUserPasswordEntity = new RegisterUserPasswordEntity($userId, $passwordValueObject);
        $this->usersPassword->registerPassword($userId, $registerUserPasswordEntity);
        return $userId;
    }
}
