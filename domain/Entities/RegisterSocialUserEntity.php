<?php
namespace Domain\Entities;

use Domain\ValueObjects\{
    RegisterSocialUserValueObject,
    TimeStampValueObject
};
use Illuminate\Contracts\Support\Arrayable;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialUserEntity
 * @package Domain\Entities
 */
class RegisterSocialUserEntity implements Arrayable
{
    private $id;
    private $socialServiceName;
    private $socialUserId;
    private $timeStamp;

    /**
     * RegisterSocialUserEntity constructor.
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     */
    public function __construct(
        int $userId,
        string $socialServiceName,
        SocialUser $socialUser
    ) {
        $this->id = $userId;
        $registerSocialUserValueObject = new RegisterSocialUserValueObject($socialServiceName, $socialUser);
        $this->socialServiceName = $registerSocialUserValueObject->getSocialServiceName();
        $this->socialUserId = $registerSocialUserValueObject->getSocialUserId();
        $this->timeStamp = new TimeStampValueObject();
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
            'created_at' => $this->timeStamp->getNow(),
            'updated_at' => $this->timeStamp->getNow(),
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
        return $this->timeStamp->getNow();
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->timeStamp->getNow();
    }
}
