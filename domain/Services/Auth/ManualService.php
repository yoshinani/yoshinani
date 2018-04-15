<?php
namespace Domain\Services\Auth;

use Domain\Specification\ManualLoginSpecification;
use Exception;
use Domain\Entities\UserEntity;
use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
use Domain\Entities\UserDetailEntity;
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
     * @return RegisterUserEntity
     */
    public function registerUser(array $oldRequest): RegisterUserEntity
    {
        $userEntity = $this->manualRepository->getUser($oldRequest['email']);
        if (is_null($userEntity)) {
            $userEntity = $this->manualRepository->registerUser($oldRequest);
            $password = $this->manualRepository->getUserPassword($userEntity->getId());
            $userEntity->setPassword($password);
        }

        return $userEntity;
    }

    /**
     * @param array $oldRequest
     * @param RegisterUserEntity $userEntity
     * @return bool
     */
    public function login(array $oldRequest, RegisterUserEntity $userEntity): bool
    {
        return $this->manualLoginSpecification->isCondition($oldRequest, $userEntity);
    }
}
