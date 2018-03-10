<?php

namespace Domain\Services\Auth;

use Domain\Specification\ManualLoginSpecification;
use Exception;
use Domain\Entities\{
    UserEntity,
    UserDetailEntity
};
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;

/**
 * Class ManualService
 * @package Domain\Services\Auth
 */
class ManualService
{
    private $manualLoginSpecification;
    private $authRepository;

    /**
     * ManualService constructor.
     * @param ManualLoginSpecification $manualLoginSpecification
     * @param ManualRepositoryInterface $authRepository
     */
    public function __construct(
        ManualLoginSpecification $manualLoginSpecification,
        ManualRepositoryInterface $authRepository
    ) {
        $this->manualLoginSpecification = $manualLoginSpecification;
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
        return $this->manualLoginSpecification->isCondition($oldRequest, $userDetailEntity);
    }

}
