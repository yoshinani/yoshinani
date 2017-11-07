<?php
namespace Domain\Entities;

use Domain\ValueObjects\ProviderUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ProviderUserEntity implements Arrayable
{
    private $id;
    private $userValueObjectId;
    private $userName;
    private $userEmail;
    private $providerUserValueObjectId;
    private $providerName;
    private $providerUserId;
    private $providerUserName;
    private $providerUserEmail;


    public function __construct(
        int $userId,
        UserValueObject $userValueObject,
        ProviderUserValueObject $providerUser
    )
    {
        $this->id = $userId;
        $this->userValueObjectId = $userValueObject->getId();
        $this->userName = $userValueObject->getName();
        $this->userEmail = $userValueObject->getEmail();
        $this->providerUserValueObjectId = $providerUser->getUserId();
        $this->providerName = $providerUser->getProviderName();
        $this->providerUserId = $providerUser->getProviderUserId();
        $this->providerUserName = $providerUser->getProviderUserName();
        $this->providerUserEmail = $providerUser->getProviderUserEmail();

    }

    public function toArray()
    {
        return [
            'id'                => $this->id,
            'userValueObjectId' => $this->userValueObjectId,
            'userName'          => $this->userName,
            'userEmail'         => $this->userEmail,
            'providerUserValueObjectId' => $this->providerUserValueObjectId,
            'providerName'              => $this->providerName,
            'providerUserId'            => $this->providerUserId,
            'providerUserName'          => $this->providerUserName,
            'providerUserEmail'         => $this->providerUserEmail,
        ];
    }
}