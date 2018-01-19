<?php

namespace Tests\Unit;

use Domain\ValueObjects\UserValueObject;
use Tests\TestCase;

class UserValueObjectTest extends TestCase
{
    private $userVo;

    public function setUp()
    {
        parent::setUp();
        $userRecord = (object)[
            'email' => 'test@test.test',
        ];
        $this->userVo = new UserValueObject($userRecord);
    }

    /**
     * Matches the acquired email.
     * 取得した電子メールに一致します。
     * @test
     */
    public function getEmailMatch()
    {
        $this->assertEquals($this->userVo->getEmail(), 'test@test.test');
    }
}
