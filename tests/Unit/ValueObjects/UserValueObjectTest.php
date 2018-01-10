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

    public function testGetUserName()
    {
        $this->assertEquals($this->userVo->getName(), 'testName');
    }

    public function testGetUserEmail()
    {
        $this->assertEquals($this->userVo->getEmail(), 'test@test.test');
    }
}
