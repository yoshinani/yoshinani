<?php
namespace Domain\Entities;

use Domain\ValueObjects\{
    RegisterSocialUserValueObject,
    TimeStampValueObject
};
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
    private $createdAt;
    private $updatedAt;

    /**
     * RegisterSocialUserEntity constructor.
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
        $timeStampValueObject = new TimeStampValueObject();
        $this->createdAt = $timeStampValueObject->getNow();
        $this->updatedAt = $timeStampValueObject->getNow();
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
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
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

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string 
    {
        return$this->updatedAt;
    }
}
