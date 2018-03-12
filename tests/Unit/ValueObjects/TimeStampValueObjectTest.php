<?php
namespace Tests\Unit;

use Domain\ValueObjects\TimeStampValueObject;
use Tests\TestCase;

class TimeStampValueObjectTest extends TestCase
{
    private $timeStamp;

    public function setUp()
    {
        parent::setUp();
        $this->timeStamp = new TimeStampValueObject();
    }

    /**
     * Current date and time formats match
     * 現在の日付と時刻の形式が一致する
     * @test
     */
    public function getNowFormat()
    {
        $this->assertEquals($this->timeStamp->getNow(), date('Y-m-d H:i:s'));
    }
}
