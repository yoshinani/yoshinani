<?php
namespace Domain\Entities;

use Domain\ValueObjects\SocialUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class SocialUserEntity
 * @package Domain\Entities
 */
class SocialUserEntity implements Arrayable
{
    private $id;
    private $socialServiceName;
    private $socialUserId;
    private $socialUserName;

    /**
     * SocialUserEntity constructor.
     * @param int $userId
     * @param SocialUserValueObject $socialUserValueObject
     */
    public function __construct(
        int $userId,
        SocialUserValueObject $socialUserValueObject
    ) {
        $this->id = $userId;
        $this->socialServiceName = $socialUserValueObject->getSocialServiceName();
        $this->socialUserId = $socialUserValueObject->getSocialUserId();
        $this->socialUserName = $socialUserValueObject->getSocialUserName();
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
            'socialUserName' => $this->socialUserName,
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSocialServiceName()
    {
        return $this->socialServiceName;
    }

    public function getSocialUserId()
    {
        return $this->socialUserId;
    }

    public function getSocialUserName()
    {
        return $this->socialUserName;
    }
}
