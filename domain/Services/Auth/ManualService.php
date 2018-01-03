<?php

namespace Domain\Services\Auth;

use Auth;
use Exception;
use Domain\Entities\{
    UserEntity,
    UserDetailEntity
};
use Infrastructure\Interfaces\AuthRepositoryInterface;

/**
 * Class ManualService
 * @package Domain\Services\Auth
 */
class ManualService
{
    private $authRepository;

    /**
     * ManualService constructor.
     * @param AuthRepositoryInterface $authRepository
     */
    public function __construct(
        AuthRepositoryInterface $authRepository
    ) {
        $this->authRepository = $authRepository;
    }

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity
    {
        $userEntity = $this->authRepository->findUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $this->authRepository->registerUser($oldRequest);
            $userEntity = $this->authRepository->findUser($oldRequest['email']);
        }

        return $userEntity;
    }

    /**
     * @param array $oldRequest
     * @return UserDetailEntity
     * @throws Exception
     */
    public function getUserDetail(array $oldRequest): UserDetailEntity
    {
        $userId = $this->authRepository->getUserId($oldRequest);
        if (is_null($userId)) {
            throw new Exception('User does not exist');
        }
        return $this->authRepository->getUserDetail($userId);
    }

    /**
     * @param array $oldRequest
     * @param int $userId
     * @return bool
     */
    public function login(array $oldRequest, int $userId): bool
    {
        $userDetailEntity = $this->authRepository->getUserDetail($userId);

        if ($oldRequest['email'] !== $userDetailEntity->getUserEmail()) {
            \Log::info("\n【ERROR】Email does not match\n"
                .'Email:'.$oldRequest['email']."\n"
                .'Password:'.encrypt($oldRequest['password'])
            );
            return false;
        }

        if ($oldRequest['password'] !== $userDetailEntity->getPassword()) {
            \Log::info("\n【ERROR】Password does not match\n"
                .'Email:'.$oldRequest['email']."\n"
                .'Password:'.encrypt($oldRequest['password'])
            );
            return false;
        }

        if (!$userDetailEntity->getActiveStatus()) {
            \Log::info("\n【ERROR】Not a living user\n"
                .'Email:'.$oldRequest['email']."\n"
                .'Password:'.encrypt($oldRequest['password'])
            );
            return false;
        }

        if (!Auth::loginUsingId($userDetailEntity->getUserId(), true)) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                .'Email:'.$oldRequest['email']."\n"
                .'Password:'.encrypt($oldRequest['password'])
            );
            return false;
        }

        return true;
    }

}
