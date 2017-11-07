<?php

namespace Domain\Entities;

use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class SocialUserAccountEntity implements Arrayable
{
    private $id;
    private $userValueObjectId;
    private $userName;
    private $userEmail;
    private $socialAccountValueObjectId;
    private $providerName;
    private $providerUserId;


    public function __construct(
        int $userId,
        UserValueObject $userValueObject,
        SocialAccountValueObject $socialAccountValueObject
    )
    {
        $this->id = $userId;
        $this->userValueObjectId = $userId;$userValueObject->getId();
        $this->userName = $userValueObject->getName();
        $this->userEmail = $userValueObject->getEmail();
        $this->socialAccountValueObjectId = $socialAccountValueObject->getUserId();
        $this->providerName = $socialAccountValueObject->getProviderName();
        $this->providerUserId = $socialAccountValueObject->getProviderUserId();
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
            'userValueObjectId' => $this->userValueObjectId,
            'userName' => $this->userName,
            'userEmail' => $this->userEmail,
            'socialAccountValueObjectId' => $this->socialAccountValueObjectId,
            'providerName'   => $this->providerName,
            'providerUserId' => $this->providerUserId,
        ];
    }
}