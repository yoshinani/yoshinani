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

    /**
     * TimeStampValueObject constructor.
     */
    public function __construct()
    {
        $this->getCreatedAt = $this->getCreatedAt();
        $this->getUpdatedAt = $this->getCreatedAt();
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        $carbon = Carbon::now();
        return $carbon->toDateTimeString();
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        $carbon = Carbon::now();
        return $carbon->toDateTimeString();
    }
}
