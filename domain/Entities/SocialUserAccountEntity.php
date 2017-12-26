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
    private $socialServiceName;
    private $socialUserId;

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
        $socialAccountValueObject = new SocialAccountValueObject($socialAccountRecord);
        $this->socialServiceName = $socialAccountValueObject->getSocialServiceName();
        $this->socialUserId = $socialAccountValueObject->getSocialUserId();
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
            'socialServiceName' => $this->socialServiceName,
            'socialUserId' => $this->socialUserId,
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
    public function getSocialServiceName(): string
    {
        return $this->socialServiceName;
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->socialUserId;
    }
}
