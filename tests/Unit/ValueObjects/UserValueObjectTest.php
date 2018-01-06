<?php

namespace Tests\Unit;

use Domain\ValueObjects\UserValueObject;
use Tests\TestCase;

class UserValueObjectTest extends TestCase
{
    private $user;
    private $userVo;

    public function setUp()
    {
        parent::setUp();
        $this->user = (object)[
            'name' => 'testName',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $this->userVo = new UserValueObject($this->user);
    }

    public function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testGetUserName()
    {
        $this->assertEquals($this->userVo->getUserName(), 'testName');
    }

    public function testGetUserEmail()
    {
        $this->assertEquals($this->userVo->getUserEmail(), 'test@test.test');
    }
}
