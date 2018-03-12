<?php
namespace Tests\Unit;

use Domain\Entities\UserEntity;
use Tests\TestCase;

class UserEntityTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $userRecord = (object) [
            'id'    => 1,
            'name'  => 'testName',
            'email' => 'test@test.test',
        ];
        $this->user = new UserEntity($userRecord);
    }

    /**
     * Array key matches
     * 配列のキーが一致します。
     * @test
     */
    public function toArrayMatch()
    {
        $this->assertArrayHasKey('id', $this->user->toArray());
        $this->assertArrayHasKey('userName', $this->user->toArray());
        $this->assertArrayHasKey('userEmail', $this->user->toArray());
        $this->assertCount(3, $this->user->toArray());
    }

    /**
     * Matches the acquired id.
     * 取得したidと一致します。
     * @test
     */
    public function getUserIdMatch()
    {
        $this->assertEquals($this->user->getUserId(), 1);
    }

    /**
     * Matches the acquired name.
     * 取得した名前と一致します。
     * @test
     */
    public function getNameMatch()
    {
        $this->assertEquals($this->user->getUserName(), 'testName');
    }

    /**
     * Matches the acquired email.
     * 取得した電子メールに一致します。
     * @test
     */
    public function getEmailMatch()
    {
        $this->assertEquals($this->user->getuserEmail(), 'test@test.test');
    }
}
