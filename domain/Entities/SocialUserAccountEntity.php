<?php

namespace Domain\Entities;

use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class SocialUserAccountEntity
 * @package Domain\Entities
 */
class SocialUserAccountEntity implements Arrayable
{
    private $id;
    private $userName;
    private $userEmail;
    private $socialServiceName;
    private $socialUserId;

    /**
     * SocialUserAccountEntity constructor.
     * @param int $userId
     * @param UserValueObject $userValueObject
     * @param SocialAccountValueObject $socialAccountValueObject
     */
    public function __construct(
        int $userId,
        UserValueObject $userValueObject,
        SocialAccountValueObject $socialAccountValueObject
    )
    {
        $this->id                = $userId;
        $this->userName          = $userValueObject->getUserName();
        $this->userEmail         = $userValueObject->getUserEmail();
        $this->socialServiceName = $socialAccountValueObject->getSocialServiceName();
        $this->socialUserId      = $socialAccountValueObject->getSocialUserId();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                => $this->id,
            'userName'          => $this->userName,
            'userEmail'         => $this->userEmail,
            'socialServiceName' => $this->socialServiceName,
            'socialUserId'      => $this->socialUserId,
        ];
    }
}