<?php
namespace Domain\Specification;

use Auth;
use Domain\Entities\UserDetailEntity;

class ManualLoginSpecification
{
    /**
     * @param array $oldRequest
     * @param UserDetailEntity $userDetailEntity
     * @return bool
     */
    public function isCondition(
        array $oldRequest,
        UserDetailEntity $userDetailEntity
    ): bool {
        if ($oldRequest['email'] !== $userDetailEntity->getUserEmail()) {
            \Log::info("\n【ERROR】Email does not match\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if ($oldRequest['password'] !== $userDetailEntity->getPassword()) {
            \Log::info("\n【ERROR】Password does not match\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if (!$userDetailEntity->getActiveStatus()) {
            \Log::info("\n【ERROR】Not a living user\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if (!Auth::loginUsingId($userDetailEntity->getUserId(), true)) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        return true;
    }
}
