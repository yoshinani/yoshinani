<?php

namespace Tests\Unit;

use Domain\ValueObjects\SocialUserValueObject;
use Laravel\Socialite\One\User;
use Tests\TestCase;

class SocialUserValueObjectTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $driverName = 'driverName';
        $socialUser = new User();
        $socialUser->id = 1;
        $this->user = new SocialUserValueObject($driverName, $socialUser);
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
