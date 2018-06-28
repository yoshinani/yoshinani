<?php
namespace Domain\Specification;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Exception;
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
     * @param SocialUserAccountEntity $socialUserAccountEntity
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return bool
     */
    public function hasSocialAccount(SocialUserAccountEntity $socialUserAccountEntity, string $driverName, SocialUser $socialUser): bool
    {
        foreach ($socialUserAccountEntity->getSocialAccounts() as $account) {
            if (in_array($driverName, $account, true)) {
                return false;
            }
            if (in_array($socialUser->getId(), $account, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @param SocialUserAccountEntity $socialUserAccountEntity
     * @return bool
     */
    public function isCondition(
        string $driverName,
        SocialUser $socialUser,
        SocialUserAccountEntity $socialUserAccountEntity
    ): bool {
        if ($this->hasSocialAccount($socialUserAccountEntity, $driverName, $socialUser)) {
            return false;
        }

        return true;
    }
}
