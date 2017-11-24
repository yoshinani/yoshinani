<?php

namespace Infrastructure\Repositories;

use Domain\Entities\RegisterUserEntity;
use Domain\Entities\RegisterUserPasswordEntity;
use Domain\Entities\UserEntity;
use Domain\Entities\UserPasswordEntity;
use Domain\ValueObjects\PasswordValueObject;
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
    public function registerUser(array $oldRequest)
    {
        $userRecord = (object)$oldRequest;
        $userValueObject = new UserValueObject($userRecord);
        $registerUserEntity = new RegisterUserEntity($userRecord, $userValueObject);
        $this->users->registerUser($registerUserEntity);
        $userId = $this->users->getUserId($registerUserEntity->getEmail());
        $passwordValueObject = new PasswordValueObject($userRecord);
        $registerUserPasswordEntity = new RegisterUserPasswordEntity($userId, $passwordValueObject);
        $this->usersPassword->registerPassword($userId, $registerUserPasswordEntity);
    }
}
