<?php
namespace Domain\Services;

use Domain\Entities\UserEntity;
use Domain\Specification\ManualLoginSpecification;
use Illuminate\Auth\AuthManager;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;

/**
 * Class ManualService
 * @package Domain\Services\Auth
 */
class AuthService
{
    private $authManager;
    private $manualLoginSpecification;
    private $manualRepository;

    /**
     * AuthService constructor.
     * @param AuthManager $authManager
     * @param ManualLoginSpecification $manualLoginSpecification
     * @param ManualRepositoryInterface $manualRepository
     */
    public function __construct(
        AuthManager $authManager,
        ManualLoginSpecification $manualLoginSpecification,
        ManualRepositoryInterface $manualRepository
    ) {
        $this->authManager = $authManager->guard('web');
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
        $condition = $this->manualLoginSpecification->isCondition($oldRequest, $userEntity);
        if ($condition) {
            $this->authManager->loginUsingId($userEntity->getId(), true);
        }
        return $condition;
    }
}
