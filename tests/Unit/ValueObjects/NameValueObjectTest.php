<?php

namespace Tests\Unit;

use Domain\ValueObjects\NameValueObject;
use Tests\TestCase;

class NameValueObjectTest extends TestCase
{
    private $nameVo;

    public function setUp()
    {
        parent::setUp();
        $userRecord = (object)[
            'name' => 'testName',
            'nickname' => 'testNickName'
        ];
        $this->nameVo = new NameValueObject($userRecord);
    }

    /**
     * Matches the acquired name.
     * 取得した名前と一致します。
     * @test
     */
    public function getNameMatch()
    {
        $this->assertEquals($this->nameVo->getName(), 'testName');
    }

    /**
     * Matches the acquired nickname.
     * 取得したニックネームと一致します。
     * @test
     */
    public function getNickNameMatch()
    {
        $this->assertEquals($this->nameVo->getNickName(), 'testNickName');
    }


}
