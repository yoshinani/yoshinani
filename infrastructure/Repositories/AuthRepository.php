<?php

namespace Infrastructure\Repositories;

use Domain\Entities\RegisterUserEntity;
use Domain\ValueObjects\RegisterUserValueObject;
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
        $registerUserValueObject = new RegisterUserValueObject($oldRequest);
        $registerUserEntity = new RegisterUserEntity($oldRequest['email'], $registerUserValueObject);
        return $this->users->setUser($registerUserEntity);
    }
}
