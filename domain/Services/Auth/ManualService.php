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
    private $manualRepository;

    /**
     * ManualService constructor.
     * @param ManualLoginSpecification $manualLoginSpecification
     * @param ManualRepositoryInterface $manualRepository
     */
    public function __construct(
        ManualLoginSpecification $manualLoginSpecification,
        ManualRepositoryInterface $manualRepository
    ) {
        $this->manualLoginSpecification = $manualLoginSpecification;
        $this->manualRepository = $manualRepository;
    }

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity
    {
        $userEntity = $this->manualRepository->findUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $this->manualRepository->registerUser($oldRequest);
            $userEntity = $this->manualRepository->findUser($oldRequest['email']);
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
        $userId = $this->manualRepository->getUserId($oldRequest);
        if (is_null($userId)) {
            throw new Exception('User does not exist');
        }
        return $this->manualRepository->getUserDetail($userId);
    }

    /**
     * @param array $oldRequest
     * @param int $userId
     * @return bool
     */
    public function login(array $oldRequest, int $userId): bool
    {
        $userDetailEntity = $this->manualRepository->getUserDetail($userId);
        return $this->manualLoginSpecification->isCondition($oldRequest, $userDetailEntity);
    }

}
