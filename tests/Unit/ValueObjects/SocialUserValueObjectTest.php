<?php

namespace Tests\Unit;

use Domain\ValueObjects\SocialUserValueObject;
use Mockery;
use Tests\TestCase;

class SocialUserValueObjectTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $driverName = 'driverName';
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn(1);
        $this->user = new SocialUserValueObject($driverName, $abstractUser);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * Matches the acquired DriverName.
     * 取得したドライバー名と一致します。
     * @test
     */
    public function getDriverNameMatch()
    {
        $this->assertEquals($this->user->getDriverName() , 'driverName');
    }

    /**
     * Matches the acquired SocialUserId.
     * 取得したソーシャルユーザIDに一致します。
     * @test
     */
    public function getSocialUserIdMatch()
    {
        $this->assertEquals($this->user->getSocialUserId(), 1);
    }
}
