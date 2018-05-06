<?php
namespace Domain\Entities;

use Domain\ValueObjects\SocialUserValueObject;
use Domain\ValueObjects\TimeStampValueObject;
use Illuminate\Contracts\Support\Arrayable;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialUserEntity
 * @package Domain\Entities
 */
class SocialUserEntity implements Arrayable
{
    private $userEntity;
    private $socialUser;
    private $timeStamp;

    /**
     * SocialUserEntity constructor.
     * @param UserEntity $userEntity
     * @param string $driverName
     * @param SocialUser $socialUser
     */
    public function __construct(
        UserEntity $userEntity,
        string $driverName,
        SocialUser $socialUser
    ) {
        $this->userEntity = $userEntity;
        $this->socialUser = new SocialUserValueObject($driverName, $socialUser);
        $this->timeStamp  = new TimeStampValueObject();
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
            'driverName'   => $this->getDriverName(),
            'socialUserId' => $this->getSocialUserId(),
            'created_at'   => $this->getCreatedAt(),
            'updated_at'   => $this->getUpdatedAt(),
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
     * @return string
     */
    public function getDriverName(): string
    {
        return $this->socialUser->getDriverName();
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->socialUser->getSocialUserId();
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
