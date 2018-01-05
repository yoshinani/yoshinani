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
    private $social;
    private $timeStamp;

    /**
     * RegisterSocialUserEntity constructor.
     * @param int $userId
     * @param string $driverName
     * @param SocialUser $socialUser
     */
    public function __construct(
        int $userId,
        string $driverName,
        SocialUser $socialUser
    ) {
        $this->id = $userId;
        $this->social = new RegisterSocialUserValueObject($driverName, $socialUser);
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
            'socialServiceName' => $this->social->getSocialServiceName(),
            'socialUserId' => $this->social->getSocialUserId(),
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
        return $this->social->getSocialServiceName();
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->social->getSocialUserId();
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
