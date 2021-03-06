<?php
namespace Infrastructure\Interfaces;

use Domain\Entities\UserEntity;
use Exception;
use Laravel\Socialite\Contracts\User as SocialUser;
use stdClass;

/**
 * Interface UserRepositoryInterface
 * @package Infrastructure\Interfaces\Auth
 */
interface UserRepositoryInterface
{
    /**
     * @param int $userId
     * @return stdClass|null
     */
    public function getUserPassword(int $userId): ?stdClass;

    /**
     * @param string $email
     * @return UserEntity|null
     */
    public function getUser(string $email): ?UserEntity;

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity;

    /**
     * @param SocialUser $socialUser
     * @return UserEntity
     */
    public function socialRegisterUser(SocialUser $socialUser): UserEntity;

    /**
     * @param int $userId
     * @return UserEntity
     */
    public function getLoginUser(int $userId): UserEntity;

    /**
     * @param UserEntity $userEntity
     * @throws Exception
     */
    public function deleteUser(UserEntity $userEntity);
}
