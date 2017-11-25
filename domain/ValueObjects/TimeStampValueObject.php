<?php

namespace Domain\ValueObjects;

use Carbon\Carbon;

/**
 * Class TimeStampValueObject
 * @package Domain\ValueObjects
 */
class TimeStampValueObject
{
    private $getCreatedAt;
    private $getUpdatedAt;

    public function __construct()
    {
        $this->getCreatedAt = $this->getCreatedAt();
        $this->getUpdatedAt = $this->getCreatedAt();
    }

    public function getCreatedAt()
    {
        $carbon = Carbon::now();
        return $carbon->toDateTimeString();
    }

    public function getUpdatedAt()
    {
        $carbon = Carbon::now();
        return $carbon->toDateTimeString();
    }
}
