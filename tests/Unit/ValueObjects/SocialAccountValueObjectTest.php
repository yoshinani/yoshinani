<?php
namespace Tests\Unit;

use Domain\ValueObjects\SocialAccountValueObject;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SocialAccountValueObjectTest extends TestCase
{
    /**
     * socialAccountsが存在する
     *  クラス変数が存在する
     *  配列の数が正しい
     *   keyが全て存在する
     *   valが正しい値が入っている
     *   valの値が等しい
     *   valの型が正しい
     * socialAccountsが空
     */
    private $socialAccounts;
    private $getSocialAccounts;

    public function setUp()
    {
        parent::setUp();
        $items = (object) [
            0 => [
                'id'             => 101,
                'user_id'        => 10001,
                'driver_name'    => 'driverName',
                'social_user_id' => 1000001,
                'created_at'     => '2018-04-30 23:59:59',
                'updated_at'     => '2018-04-30 23:59:59'
                ]
        ];
        $socialAccountRecord  = new Collection($items);
        $this->socialAccounts = new SocialAccountValueObject($socialAccountRecord);
        $this->getSocialAccounts = $this->socialAccounts->getSocialAccounts();
    }

    /**
     * @test
     */
    public function useSocialAccountVO()
    {
        $this->assertInstanceOf(SocialAccountValueObject::class, $this->socialAccounts);
    }

    /**
     * @test
     */
    public function hasClassVariable()
    {
        $this->assertObjectHasAttribute('socialAccounts', $this->socialAccounts);
    }

    /**
     * @test
     */
    public function matchesTheNumberOfSyncedAccounts()
    {
        $socialAccounts = $this->getSocialAccounts;
        $this->assertCount(1, $socialAccounts);

        return $socialAccounts;
    }

    /**
     * @test
     * @depends matchesTheNumberOfSyncedAccounts
     * @param Collection $socialAccounts
     * @return array
     */
    public function existAccountRecordKey(Collection $socialAccounts)
    {
        $socialAccount = $socialAccounts[0];
        $this->assertArrayHasKey('id', $socialAccount);
        $this->assertArrayHasKey('user_id', $socialAccount);
        $this->assertArrayHasKey('driver_name', $socialAccount);
        $this->assertArrayHasKey('social_user_id', $socialAccount);
        $this->assertArrayHasKey('created_at', $socialAccount);
        $this->assertArrayHasKey('updated_at', $socialAccount);

        return $socialAccount;
    }

    /**
     * @test
     * @depends existAccountRecordKey
     * @param array $socialAccount
     */
    public function matchesAccountValue(array $socialAccount)
    {
        $this->assertEquals($socialAccount['id'], 101);
        $this->assertEquals($socialAccount['user_id'], 10001);
        $this->assertEquals($socialAccount['driver_name'], 'driverName');
        $this->assertEquals($socialAccount['social_user_id'], 1000001);
        $this->assertEquals($socialAccount['created_at'], '2018-04-30 23:59:59');
        $this->assertEquals($socialAccount['updated_at'], '2018-04-30 23:59:59');
    }

    /**
     * @test
     * @depends existAccountRecordKey
     * @depends matchesAccountValue
     * @param array $socialAccount
     */
    public function matchesAccountValueType(array $socialAccount)
    {
        $this->assertInternalType('int', $socialAccount['id']);
        $this->assertInternalType('int', $socialAccount['user_id']);
        $this->assertInternalType('string', $socialAccount['driver_name']);
        $this->assertInternalType('int', $socialAccount['social_user_id']);
        $this->assertInternalType('string', $socialAccount['created_at']);
        $this->assertInternalType('string', $socialAccount['updated_at']);
    }

    /**
     * @test
     */
    public function emptyItems()
    {
        $items               = (object) [];
        $socialAccountRecord = new Collection($items);
        $socialAccounts      = new SocialAccountValueObject($socialAccountRecord);
        $this->assertEmpty($socialAccounts->getSocialAccounts());
    }
}
