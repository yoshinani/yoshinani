<?php
namespace Domain\Entities;

use Domain\ValueObjects\ProviderUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ProviderUserEntity implements Arrayable
{
    private $id;
    private $userName;
    private $userEmail;
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
        $this->id                = $userId;
        $this->userName          = $userValueObject->getUserName();
        $this->userEmail         = $userValueObject->getUserEmail();
        $this->providerName      = $providerUser->getProviderName();
        $this->providerUserId    = $providerUser->getProviderUserId();
        $this->providerUserName  = $providerUser->getProviderUserName();
        $this->providerUserEmail = $providerUser->getProviderUserEmail();

    }

    public function toArray()
    {
        return [
            'id'                => $this->id,
            'userName'          => $this->userName,
            'userEmail'         => $this->userEmail,
            'providerName'      => $this->providerName,
            'providerUserId'    => $this->providerUserId,
            'providerUserName'  => $this->providerUserName,
            'providerUserEmail' => $this->providerUserEmail,
        ];
    }
}