<?php
namespace Domain\Entities;

use Domain\ValueObjects\RegisterSocialUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class SocialUserEntity
 * @package Domain\Entities
 */
class RegisterSocialUserEntity implements Arrayable
{
    private $id;
    private $socialServiceName;
    private $socialUserId;

    /**
     * SocialUserEntity constructor.
     * @param int $userId
     * @param RegisterSocialUserValueObject $registerSocialUserValueObject
     */
    public function __construct(
        int $userId,
        RegisterSocialUserValueObject $registerSocialUserValueObject
    ) {
        $this->id = $userId;
        $this->socialServiceName = $registerSocialUserValueObject->getSocialServiceName();
        $this->socialUserId = $registerSocialUserValueObject->getSocialUserId();
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
     * @return string
     */
    public function getSocialServiceName()
    {
        return $this->socialServiceName;
    }

    /**
     * @return string
     */
    public function getSocialUserId()
    {
        return $this->socialUserId;
    }
}
