<?php
namespace Tests\Unit;

use Domain\ValueObjects\SocialAccountValueObject;
use Tests\TestCase;

class SocialAccountValueObjectTest extends TestCase
{
    private $socialAccount;

    public function setUp()
    {
        parent::setUp();
        $socialAccountRecord = (object) [
            'user_id'        => 1,
            'driver_name'    => 'socialDriver',
            'social_user_id' => 10
        ];
        $this->socialAccount = new SocialAccountValueObject($socialAccountRecord);
    }

    /**
     * Matches the acquired userId.
     * 取得したユーザIDと一致します。
     * @test
     */
    public function getUserIdMatch()
    {
        $this->assertEquals($this->socialAccount->getUserId(), 1);
    }

    /**
     * Matches the acquired driverName.
     * 取得したドライバー名前と一致します。
     * @test
     */
    public function getDriverNameMatch()
    {
        $this->assertEquals($this->socialAccount->getDriverName(), 'socialDriver');
    }

    /**
     * Matches the acquired socialUserId.
     * 取得したソーシャルユーザIDと一致します。
     * @test
     */
    public function getSocialUserIdMatch()
    {
        $this->assertEquals($this->socialAccount->getSocialUserId(), 10);
    }
}
