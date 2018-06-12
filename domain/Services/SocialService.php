<?php
namespace Domain\Services;

use Domain\Entities\UserEntity;
use Domain\Entities\SocialUserAccountEntity;
use Illuminate\Http\RedirectResponse;
use Infrastructure\Interfaces\Auth\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;
use Socialite;

/**
 * Class SocialService
 * @package Domain\Services\Auth
 */
class SocialService
{
    private $socialRepository;

    /**
     * SocialService constructor.
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        SocialRepositoryInterface $socialRepository
    ) {
        $this->socialRepository = $socialRepository;
    }

    /**
     * @param $driverName
     * @return RedirectResponse
     */
    public function redirectToProvider($driverName): RedirectResponse
    {
        return Socialite::driver($driverName)->redirect();
    }

    /**
     * @param $driverName
     * @return SocialUser
     */
    public function getSocialUser($driverName): SocialUser
    {
        return Socialite::driver($driverName)->user();
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @param UserEntity $userEntity
     * @return SocialUserAccountEntity
     */
    public function syncAccount(string $driverName, SocialUser $socialUser, UserEntity $userEntity): SocialUserAccountEntity
    {
        $this->socialRepository->syncAccount($userEntity, $driverName, $socialUser);

        return $this->socialRepository->getSocialAccounts($userEntity);
    }
}
