<?php

namespace Infrastructure\Repositories;

use Domain\Entities\RegisterUserEntity;
use Domain\Entities\RegisterUserPasswordEntity;
use Domain\Entities\UserDetailEntity;
use Domain\Entities\UserEntity;
use Domain\Entities\UserPasswordEntity;
use Domain\ValueObjects\PasswordValueObject;
use Domain\ValueObjects\TimeStampValueObject;
use Domain\ValueObjects\UserValueObject;
use Infrastructure\DataSources\Database\UsersPassword;
use Infrastructure\Interfaces\AuthRepositoryInterface;
use Infrastructure\DataSources\Database\Users;

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
    public function findUser(array $oldRequest)
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
    public function getUserPassword(int $userId)
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
    public function getUserId(string $email)
    {
        $result = $this->users->getUserId($email);
        if (is_null($result)) {
            return null;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserDetail(int $userId)
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
    public function registerUser(array $oldRequest)
    {
        $userRecord = (object)$oldRequest;
        $userValueObject = new UserValueObject($userRecord);
        $timeStampValueObject = new TimeStampValueObject();
        $registerUserEntity = new RegisterUserEntity($userRecord, $userValueObject, $timeStampValueObject);
        $userId = $this->users->registerUser($registerUserEntity);
        $passwordValueObject = new PasswordValueObject($userRecord);
        $registerUserPasswordEntity = new RegisterUserPasswordEntity($userId, $passwordValueObject, $timeStampValueObject);
        $this->usersPassword->registerPassword($userId, $registerUserPasswordEntity);
        return $userId;
    }
}
