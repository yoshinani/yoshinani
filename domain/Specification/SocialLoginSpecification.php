<?php
namespace Domain\Specification;

use Auth;
use Exception;
use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
use Domain\Entities\UserDetailEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

class SocialLoginSpecification
{
    /**
     * @param SocialUser $socialUser
     * @throws Exception
     */
    public function isRequiredInfo(SocialUser $socialUser)
    {
        if (is_null($socialUser->getEmail())) {
            throw new Exception('Email is missing');
        }

        if (is_null($socialUser->getName())) {
            throw new Exception('Name is missing');
        }
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @param SocialUserAccountEntity $socialUserAccountEntity
     * @param RegisterUserEntity $userEntity
     * @return bool
     */
    public function isCondition(
        string $driverName,
        SocialUser $socialUser,
        SocialUserAccountEntity $socialUserAccountEntity,
        RegisterUserEntity $userEntity
    ): bool {
        if ($socialUserAccountEntity->getDriverName() != $driverName) {
            \Log::info("\n【ERROR】Authentication drivers do not match\n"
                . 'Entity:' . $socialUserAccountEntity->getDriverName() . ':' . $socialUserAccountEntity->getSocialUserId() . "\n"
                . 'Request:' . $driverName . ':' . $socialUser->getId()
            );

            return false;
        }

        if ($socialUserAccountEntity->getSocialUserId() != $socialUser->getId()) {
            \Log::info("\n【ERROR】It does not match the ID of SNS Account\n"
                . 'Entity:' . $socialUserAccountEntity->getDriverName() . ':' . $socialUserAccountEntity->getSocialUserId() . "\n"
                . 'Request:' . $driverName . ':' . $socialUser->getId()
            );

            return false;
        }

        if (!$userEntity->getActive()) {
            \Log::info("\n【ERROR】Not a living user\n"
                . 'Entity:' . $socialUserAccountEntity->getDriverName() . ':' . $socialUserAccountEntity->getSocialUserId() . "\n"
                . 'Request:' . $driverName . ':' . $socialUser->getId()
            );

            return false;
        }

        if (!Auth::loginUsingId($socialUserAccountEntity->getId())) {
            \Log::info("\n【ERROR】It is a User that does not exist\n"
                . 'Entity:' . $socialUserAccountEntity->getDriverName() . ':' . $socialUserAccountEntity->getSocialUserId() . "\n"
                . 'Request:' . $driverName . ':' . $socialUser->getId()
            );

            return false;
        }

        return true;
    }
}
