<?php

namespace Domain\ValueObjects;

use Carbon\Carbon;

/**
 * Class TimeStampValueObject
 * @package Domain\ValueObjects
 */
class TimeStampValueObject
{
    private $getMakeUp;

    /**
     * TimeStampValueObject constructor.
     */
    public function __construct()
    {
        $this->getMakeUp = $this->getMakeUp();
    }

    /**
     * @return string
     */
    public function getMakeUp()
    {
        $carbon = Carbon::now();
        return $carbon->toDateTimeString();
    }

}
