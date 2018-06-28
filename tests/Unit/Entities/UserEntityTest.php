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
            'id'       => 1,
            'email'    => 'test@test.test',
            'name'     => 'testName',
            'nickname' => 'testNickName',
            'password' => encrypt('password')
        ];
        $this->user = new UserEntity($userRecord);
        $this->user->setId(1);
        $this->user->setPassword($userRecord);
    }

    /**
     * @test
     */
    public function toArray()
    {
        $this->assertArrayHasKey('id', $this->user->toArray());
        $this->assertArrayHasKey('email', $this->user->toArray());
        $this->assertArrayHasKey('name', $this->user->toArray());
        $this->assertArrayHasKey('nickname', $this->user->toArray());
        $this->assertArrayHasKey('password', $this->user->toArray());
        $this->assertArrayHasKey('created_at', $this->user->toArray());
        $this->assertArrayHasKey('updated_at', $this->user->toArray());
        $this->assertCount(7, $this->user->toArray());
    }

    /**
     * @test
     */
    public function getId()
    {
        $this->assertEquals($this->user->getId(), 1);
    }

    /**
     * @test
     */
    public function getEmail()
    {
        $this->assertEquals($this->user->getEmail(), 'test@test.test');
    }

    /**
     * @test
     */
    public function getUserName()
    {
        $this->assertEquals($this->user->getName(), 'testName');
    }

    /**
     * @test
     */
    public function getNickName()
    {
        $this->assertEquals($this->user->getNickName(), 'testNickName');
    }

    /**
     * @test
     */
    public function createPassword()
    {
        $userRequest = (object) [
            'email'    => 'test@test.test',
            'name'     => 'testName',
            'nickname' => 'testNickName',
            'password' => 'password'
        ];
        $userEntity = new UserEntity($userRequest);
        $userEntity->setPassword($userRequest);
        $this->assertInternalType('string', $this->user->createPassword());
    }

    /**
     * @test
     */
    public function getPassword()
    {
        $this->assertEquals($this->user->getPassword(), 'password');
    }

    /**
     * @test
     */
    public function getCreatedAt()
    {
        $this->assertEquals($this->user->getCreatedAt(), date('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function getUpdatedAt()
    {
        $this->assertEquals($this->user->getUpdatedAt(), date('Y-m-d H:i:s'));
    }
}
