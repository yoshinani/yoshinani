<?php
namespace Infrastructure\Repositories\Auth;

use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
use Infrastructure\Factories\UserFactory;
use Infrastructure\Factories\RegisterUserFactory;
use Infrastructure\DataSources\Database\Users;
use Infrastructure\DataSources\Database\UsersNickName;
use Infrastructure\DataSources\Database\UsersStatus;
use Infrastructure\DataSources\Database\UsersPassword;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;
use stdClass;

/**
 * Class ManualRepository
 * @package Infrastructure\Repositories
 */
class ManualRepository implements ManualRepositoryInterface
{
    private $users;
    private $usersStatus;
    private $userNickName;
    private $usersPassword;
    private $userFactory;
    private $registerUserFactory;

    /**
     * ManualRepository constructor.
     * @param Users $users
     * @param UsersStatus $usersStatus
     * @param UsersNickName $userNickName
     * @param UsersPassword $usersPassword
     * @param UserFactory $userFactory
     * @param RegisterUserFactory $registerUserFactory
     */
    public function __construct(
        Users               $users,
        UsersStatus         $usersStatus,
        UsersNickName       $userNickName,
        UsersPassword       $usersPassword,
        UserFactory         $userFactory,
        RegisterUserFactory $registerUserFactory
    ) {
        $this->users               = $users;
        $this->usersStatus         = $usersStatus;
        $this->userNickName        = $userNickName;
        $this->usersPassword       = $usersPassword;
        $this->userFactory         = $userFactory;
        $this->registerUserFactory = $registerUserFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserPassword(int $userId): ?stdClass
    {
        $result = $this->usersPassword->getUserPassword($userId);
        if (is_null($result)) {
            return null;
        }

        return (object) $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser(string $email): ?RegisterUserEntity
    {
        $result = $this->users->getUser($email);
        if (is_null($result)) {
            return null;
        }
        $userDetail = (object) $result;

        return $this->userFactory->createRegisterUser($userDetail);
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(array $oldRequest): RegisterUserEntity
    {
        $registerUserEntity = $this->userFactory->createRegisterUser((object) $oldRequest);
        $userId             = $this->users->registerUser($registerUserEntity);
        $registerUserEntity->setId($userId);
        $registerUserEntity->setPassword((object) $oldRequest);
        $this->usersStatus->registerActive($registerUserEntity);
        $this->usersPassword->registerPassword($registerUserEntity);
        $this->userNickName->registerNickName($registerUserEntity);

        return $registerUserEntity;
    }
}
