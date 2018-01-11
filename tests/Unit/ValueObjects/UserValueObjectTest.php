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
            'name' => 'testName',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $this->userVo = new UserValueObject($userRecord);
    }

    /**
     * Matches the acquired name.
     * 取得した名前と一致します。
     * @test
     */
    public function getNameMatch()
    {
        $this->assertEquals($this->userVo->getName(), 'testName');
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
