<?php
namespace Domain\Entities;

use Domain\ValueObjects\ProviderUserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ProviderUserEntity implements Arrayable
{
    private $id;
    private $providerName;
    private $providerUserId;
    private $providerUserName;
    private $providerUserEmail;


    public function __construct(
        int $providerUserId,
        ProviderUserValueObject $providerUser
    )
    {
        $this->id = $providerUserId;
        $this->providerName = $providerUser->getProviderName();
        $this->providerUserId = $providerUser->getId();
        $this->providerUserName = $providerUser->getName();
        $this->providerUserEmail = $providerUser->getEmail();
    }

    public function toArray()
    {
        return [
            'id'             => $this->id,
            'providerName'   => $this->providerName,
            'providerUserId' => $this->providerUserId,
            'providerUserName'  => $this->providerUserName,
            'providerUserEmail' => $this->providerUserEmail,
        ];
    }
}