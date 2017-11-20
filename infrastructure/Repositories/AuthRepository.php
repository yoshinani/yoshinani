<?php

namespace Infrastructure\Repositories;

use Domain\Entities\RegisterUserEntity;
use Domain\Entities\UserEntity;
use Domain\ValueObjects\PasswordValueObject;
use Domain\ValueObjects\UserValueObject;
use Infrastructure\Interfaces\AuthRepositoryInterface;
use Infrastructure\DataSources\Database\Users;

/**
 * Class AuthRepository
 * @package Infrastructure\Repositories
 */
class AuthRepository implements AuthRepositoryInterface
{
    private $users;

    /**
     * {@inheritdoc}
     */
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(array $oldRequest)
    {
        $userRecord = (object)$oldRequest;
        $userValueObject = new UserValueObject($userRecord);
        $passwordValueObject = new PasswordValueObject($userRecord);
        $registerUserEntity = new RegisterUserEntity($userRecord, $userValueObject, $passwordValueObject);
        $this->users->setUser($registerUserEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function findUser(array $oldRequest)
    {
        $userRecord = $this->users->findUser($oldRequest['email']);
        $userValueObject = new UserValueObject($userRecord);
        $passwordValueObject = new PasswordValueObject($userRecord);
        return new UserEntity($userRecord, $userValueObject, $passwordValueObject);
    }
}
