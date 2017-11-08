<?php

namespace Domain\Entities;

use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class SocialUserAccountEntity implements Arrayable
{
    private $id;
    private $userName;
    private $userEmail;
    private $providerName;
    private $providerUserId;


    public function __construct(
        int $userId,
        UserValueObject $userValueObject,
        SocialAccountValueObject $socialAccountValueObject
    )
    {
        $this->id             = $userId;
        $this->userName       = $userValueObject->getUserName();
        $this->userEmail      = $userValueObject->getUserEmail();
        $this->providerName   = $socialAccountValueObject->getProviderName();
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
            'id'             => $this->id,
            'userName'       => $this->userName,
            'userEmail'      => $this->userEmail,
            'providerName'   => $this->providerName,
            'providerUserId' => $this->providerUserId,
        ];
    }
}