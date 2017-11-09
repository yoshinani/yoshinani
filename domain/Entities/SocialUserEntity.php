<?php
namespace Domain\Entities;

use Domain\ValueObjects\SocialUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class SocialUserEntity implements Arrayable
{
    private $id;
    private $userName;
    private $userEmail;
    private $socialServiceName;
    private $socialUserId;
    private $socialUserName;
    private $socialUserEmail;


    public function __construct(
        int $userId,
        UserValueObject $userValueObject,
        SocialUserValueObject $socialUserValueObject
    )
    {
        $this->id                = $userId;
        $this->userName          = $userValueObject->getUserName();
        $this->userEmail         = $userValueObject->getUserEmail();
        $this->socialServiceName = $socialUserValueObject->getSocialServiceName();
        $this->socialUserId      = $socialUserValueObject->getSocialUserId();
        $this->socialUserName    = $socialUserValueObject->getSocialUserName();
        $this->socialUserEmail   = $socialUserValueObject->getSocialUserEmail();

    }

    public function toArray()
    {
        return [
            'id'                => $this->id,
            'userName'          => $this->userName,
            'userEmail'         => $this->userEmail,
            'socialServiceName' => $this->socialServiceName,
            'socialUserId'      => $this->socialUserId,
            'socialUserName'    => $this->socialUserName,
            'socialUserEmail'   => $this->socialUserEmail,
        ];
    }
}