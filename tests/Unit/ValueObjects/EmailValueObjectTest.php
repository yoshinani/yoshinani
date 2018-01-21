<?php

namespace Tests\Unit;

use Domain\ValueObjects\EmailValueObject;
use Tests\TestCase;

class EmailValueObjectTest extends TestCase
{
    private $emailVo;

    public function setUp()
    {
        parent::setUp();
        $userRecord = (object)[
            'email' => 'test@test.test',
        ];
        $this->emailVo = new EmailValueObject($userRecord);
    }

    /**
     * Matches the acquired email.
     * 取得した電子メールに一致します。
     * @test
     */
    public function getEmailMatch()
    {
        $this->assertEquals($this->emailVo->getEmail(), 'test@test.test');
    }
}
