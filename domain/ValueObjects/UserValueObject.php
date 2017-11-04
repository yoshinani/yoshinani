<?php

namespace Domain\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class UserValueObject implements Arrayable
{
    private $id;
    private $name;
    private $email;

    public function __construct($userInfo)
    {
        $this->id              = $userInfo->id;
        $this->name            = $userInfo->name;
        $this->email           = $userInfo->email;
    }

    public function toArray()
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}