<?php

namespace Tests\Unit;

use Domain\ValueObjects\UserValueObject;
use Tests\TestCase;

class UserValueObjectTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $userRecord = (object)[
            'name' => 'testName',
            'email' => 'test@test.test',
        ];
        $this->user = new UserValueObject($userRecord);
    }

    /**
     * Matches the acquired name.
     * 取得した名前と一致します。
     * @test
     */
    public function getNameMatch()
    {
        $this->assertEquals($this->user->getName(), 'testName');
    }

    /**
     * Matches the acquired email.
     * 取得した電子メールに一致します。
     * @test
     */
    public function getEmailMatch()
    {
        $this->assertEquals($this->user->getEmail(), 'test@test.test');
    }
}
