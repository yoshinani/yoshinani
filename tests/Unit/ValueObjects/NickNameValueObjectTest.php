<?php
namespace Tests\Unit;

use Domain\ValueObjects\NickNameValueObject;
use Tests\TestCase;

class NickNameValueObjectTest extends TestCase
{
    private $nickname;

    /**
     * Matches the acquired nickname.
     * 取得したNicknameと一致します。
     * @test
     */
    public function getNameMatch()
    {
        $userRecord = (object) [
            'nickname' => 'testName',
        ];
        $this->nickname = new NickNameValueObject($userRecord);
        $this->assertEquals($this->nickname->getNickName(), 'testName');
    }

    /**
     * When nickname does not exist
     * nicknameが存在しない場合
     * @test
     */
    public function getNameNUll()
    {
        $userRecord = (object) [
            'nickname' => null,
        ];
        $this->nickname = new NickNameValueObject($userRecord);
        $this->assertNull(null, $this->nickname->getNickName());
    }

    /**
     * If there is no nickname, return the string "registration"
     * nicknameがない場合は、文字列 "registration" を返します
     * @test
     */
    public function getNameNUllUnregistered()
    {
        $userRecord = (object) [
            'nickname' => null,
        ];
        $this->nickname = new NickNameValueObject($userRecord);
        $this->assertEquals($this->nickname->getNickName(), 'Unregistered');
    }
}
