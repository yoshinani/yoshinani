<?php

namespace Domain\ValueObjects;

use Carbon\Carbon;

/**
 * Class TimeStampValueObject
 * @package Domain\ValueObjects
 */
class TimeStampValueObject
{
    private $getNow;

    /**
     * TimeStampValueObject constructor.
     */
    public function __construct()
    {
        $this->getNow = $this->getNow();
    }

    /**
     * @return string
     */
    public function getNow()
    {
        $carbon = Carbon::now();
        return $carbon->toDateTimeString();
    }

}
