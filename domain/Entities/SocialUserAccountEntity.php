<?php
namespace Domain\Entities;

use Domain\ValueObjects\SocialAccountValueObject;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/**
 * Class SocialUserAccountEntity
 * @package Domain\Entities
 */
class SocialUserAccountEntity implements Arrayable
{
    private $userEntity;
    private $socialAccount;

    /**
     * SocialUserAccountEntity constructor.
     * @param UserEntity $userEntity
     * @param Collection $accountCollection
     */
    public function __construct(
        UserEntity $userEntity,
        Collection $accountCollection
    ) {
        $this->userEntity    = $userEntity;
        $this->socialAccount = new SocialAccountValueObject($accountCollection);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'             => $this->getId(),
            'socialAccounts' => $this->getSocialAccounts()
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->userEntity->getId();
    }

    /**
     * @return array
     */
    public function getSocialAccounts(): array
    {
        $socialAccounts = [];
        foreach ($this->socialAccount->getSocialAccounts() as $accounts) {
            $socialAccounts[] = [
                'userId'       => $accounts->user_id,
                'driverName'   => $accounts->driver_name,
                'socialUserId' => $accounts->social_user_id
            ];
        }

        return $socialAccounts;
    }
}
