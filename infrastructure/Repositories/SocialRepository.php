<?php
namespace Infrastructure\Repositories;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Infrastructure\Factories\UserFactory;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialRepository
 * @package Infrastructure\Repositories
 */
class SocialRepository implements SocialRepositoryInterface
{
    private $socialAccounts;
    private $userFactory;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param UserFactory $userFactory
     */
    public function __construct(
        SocialAccounts      $socialAccounts,
        UserFactory         $userFactory
    ) {
        $this->socialAccounts      = $socialAccounts;
        $this->userFactory         = $userFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getSocialAccounts(UserEntity $userEntity): SocialUserAccountEntity
    {
        $accountCollection = $this->socialAccounts->getSocialAccounts($userEntity);

        return $this->userFactory->createSocialUserAccount($userEntity, $accountCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function syncAccount(UserEntity $userEntity, string $driverName, SocialUser $socialUser)
    {
        $registerSocialUserEntity = $this->userFactory->createSocialUser($userEntity, $driverName, $socialUser);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }
}
