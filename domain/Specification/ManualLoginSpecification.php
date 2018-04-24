<?php
namespace Domain\Specification;

use Auth;
use Domain\Entities\UserEntity;

class ManualLoginSpecification
{
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
            \Log::info("\n【ERROR】Email does not match\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if ($oldRequest['password'] !== $userEntity->getPassword()) {
            \Log::info("\n【ERROR】Password does not match\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if (!$userEntity->getActive()) {
            \Log::info("\n【ERROR】Not a living user\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        if (!Auth::loginUsingId($userEntity->getId(), true)) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                . 'Email:' . $oldRequest['email'] . "\n"
                . 'Password:' . encrypt($oldRequest['password'])
            );

            return false;
        }

        return true;
    }
}
