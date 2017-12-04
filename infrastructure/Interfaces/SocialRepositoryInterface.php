<?php

namespace Infrastructure\Interfaces;

use Domain\Entities\SocialUserAccountEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Interface SocialRepositoryInterface
 * @package Infrastructure\Interfaces
 */
interface SocialRepositoryInterface
{
    /**
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return SocialUserAccountEntity
     */
    public function login(string $socialServiceName, SocialUser $socialUser): SocialUserAccountEntity;
}
