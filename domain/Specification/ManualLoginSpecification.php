<?php
namespace Domain\Specification;

use Domain\Entities\UserEntity;
use Illuminate\Log\LogManager;

class ManualLoginSpecification
{
    private $logManager;

    /**
     * ManualLoginSpecification constructor.
     * @param LogManager $logManager
     */
    public function __construct(LogManager $logManager)
    {
        $this->logManager = $logManager;
    }

    /**
     * @param array $oldRequest
     * @param UserEntity $userEntity
     * @return bool
     */
    public function isCondition(
        array $oldRequest,
        UserEntity $userEntity
    ): bool {
        if ($oldRequest['email'] !== $userEntity->getEmail()) {
            $this->logManager->info("\n【ERROR】Email does not match\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if ($oldRequest['password'] !== $userEntity->getDecryptionPassword()) {
            $this->logManager->info("\n【ERROR】Password does not match\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        return true;
    }
}
