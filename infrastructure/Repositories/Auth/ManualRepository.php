<?php

namespace Infrastructure\Repositories\Auth;

use Domain\Entities\{
    RegisterUserEntity, RegisterUserNickNameEntity, RegisterUserPasswordEntity, UserDetailEntity, UserEntity, UserPasswordEntity
};
use Infrastructure\DataSources\Database\{
    Users, UsersNickName, UsersStatus, UsersPassword
};
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;

/**
 * Class AuthRepository
 * @package Infrastructure\Repositories
 */
class ManualRepository implements ManualRepositoryInterface
{
    private $users;
    private $usersStatus;
    private $userNickName;
    private $usersPassword;

    /**
     * AuthRepository constructor.
     * @param Users $users
     * @param UsersStatus $usersStatus
     * @param UsersNickName $userNickName
     * @param UsersPassword $usersPassword
     */
    public function __construct(
        Users $users,
        UsersStatus $usersStatus,
        UsersNickName $userNickName,
        UsersPassword $usersPassword
    )
    {
        $this->users = $users;
        $this->usersStatus = $usersStatus;
        $this->userNickName = $userNickName;
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
        $this->usersStatus->registerActive($userId, $registerUserEntity);
        $registerUserPasswordEntity = new RegisterUserPasswordEntity($userId, $userRecord);
        $this->usersPassword->registerPassword($userId, $registerUserPasswordEntity);
        $registerUserNickNameEntity = new RegisterUserNickNameEntity($userId, $userRecord);
        $this->userNickName->registerNickName($userId, $registerUserNickNameEntity);
        return $userId;
    }
}
