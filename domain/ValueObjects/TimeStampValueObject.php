<?php
namespace Domain\ValueObjects;

use Carbon\Carbon;

/**
 * Class TimeStampValueObject
 * @package Domain\ValueObjects
 */
class TimeStampValueObject
{
    private $carbon;

    /**
     * TimeStampValueObject constructor.
     */
    public function __construct()
    {
        $this->carbon = Carbon::now();
    }

    /**
     * @return string
     */
    public function getNow(): string
    {
        return $this->carbon->toDateTimeString();
    }
}
