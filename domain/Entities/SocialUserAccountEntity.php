<?php

namespace Domain\Entities;

use Domain\ValueObjects\SocialAccountValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

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
     * @param stdClass $socialAccountRecord
     */
    public function __construct(
        int $userId,
        stdClass $socialAccountRecord
    ) {
        $this->id = $userId;
        $this->socialAccount = new SocialAccountValueObject($socialAccountRecord);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'driverName' => $this->socialAccount->getDriverName(),
            'socialUserId' => $this->socialAccount->getSocialUserId(),
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
     * @return string
     */
    public function getDriverName(): string
    {
        return $this->socialAccount->getDriverName();
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->socialAccount->getSocialUserId();
    }
}
