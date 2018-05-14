<?php
namespace Domain\Specification;

use Illuminate\Auth\AuthManager;
use Exception;
use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

class SocialLoginSpecification
{
    private $authManager;

    /**
     * SocialLoginSpecification constructor.
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager->guard('web');
    }

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
     * @param UserEntity $userEntity
     * @return bool
     */
    public function isCondition(
        string $driverName,
        SocialUser $socialUser,
        SocialUserAccountEntity $socialUserAccountEntity,
        UserEntity $userEntity
    ): bool {
        if ($this->hasSocialAccount($socialUserAccountEntity, $driverName, $socialUser)) {
            return false;
        }

        if (!$userEntity->getActive()) {
            return false;
        }

        if (!$this->authManager->loginUsingId($socialUserAccountEntity->getId())) {
            return false;
        }

        return true;
    }
}
