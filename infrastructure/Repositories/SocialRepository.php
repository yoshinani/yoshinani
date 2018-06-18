<?php
namespace Infrastructure\Repositories;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\Factories\SocialAccountFactory;
use Infrastructure\Factories\UserFactory;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialRepository
 * @package Infrastructure\Repositories
 */
class SocialRepository implements SocialRepositoryInterface
{
    private $socialAccounts;
    private $socialAccountFactory;
    private $userFactory;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param SocialAccountFactory $socialAccountFactory
     * @param UserFactory $userFactory
     */
    public function __construct(
        SocialAccounts $socialAccounts,
        SocialAccountFactory $socialAccountFactory,
        UserFactory    $userFactory
    ) {
        $this->socialAccounts       = $socialAccounts;
        $this->socialAccountFactory = $socialAccountFactory;
        $this->userFactory          = $userFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getSocialAccounts(UserEntity $userEntity): SocialUserAccountEntity
    {
        $accountCollection = $this->socialAccounts->getSocialAccounts($userEntity);

        return $this->socialAccountFactory->createSocialUserAccount($userEntity, $accountCollection);
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
