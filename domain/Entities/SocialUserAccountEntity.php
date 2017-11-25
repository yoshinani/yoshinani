<?php

namespace Domain\Entities;

use Domain\ValueObjects\SocialAccountValueObject;
use Illuminate\Contracts\Support\Arrayable;

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
     * @param SocialAccountValueObject $socialAccountValueObject
     */
    public function __construct(
        int $userId,
        SocialAccountValueObject $socialAccountValueObject
    ) {
        $this->id = $userId;
        $this->socialServiceName = $socialAccountValueObject->getSocialServiceName();
        $this->socialUserId = $socialAccountValueObject->getSocialUserId();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSocialServiceName():string
    {
        return $this->socialServiceName;
    }

    /**
     * @return mixed
     */
    public function getSocialUserId()
    {
        return $this->socialUserId;
    }
}
