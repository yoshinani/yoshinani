<?php
namespace Domain\Services\Auth;

use Domain\Specification\ManualLoginSpecification;
use Domain\Entities\UserEntity;
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
        $this->manualRepository         = $manualRepository;
    }

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity
    {
        $userEntity = $this->manualRepository->getUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $userEntity = $this->manualRepository->registerUser($oldRequest);
            $password   = $this->manualRepository->getUserPassword($userEntity->getId());
            $userEntity->setPassword($password);
        }

        return $userEntity;
    }

    /**
     * @param array $oldRequest
     * @param UserEntity $userEntity
     * @return bool
     */
    public function login(array $oldRequest, UserEntity $userEntity): bool
    {
        return $this->manualLoginSpecification->isCondition($oldRequest, $userEntity);
    }
}
