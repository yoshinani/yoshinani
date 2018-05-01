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
    private $id;
    private $socialAccount;

    /**
     * SocialUserAccountEntity constructor.
     * @param int $userId
     * @param Collection $accountCollection
     */
    public function __construct(
        int $userId,
        Collection $accountCollection
    ) {
        $this->id            = $userId;
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
            'id'           => $this->getId(),
            'driverNames'   => $this->getDriverNames(),
            'socialUserIds' => $this->getSocialUserIds(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getDriverNames(): array
    {
        return $this->socialAccount->getDriverNames();
    }

    /**
     * @return array
     */
    public function getSocialUserIds(): array
    {
        return $this->socialAccount->getSocialUserIds();
    }
}
