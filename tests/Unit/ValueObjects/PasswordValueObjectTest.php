<?php

namespace Tests\Unit;

use Domain\ValueObjects\PasswordValueObject;
use Tests\TestCase;

class PasswordValueObjectTest extends TestCase
{
    private $passwordEncryption;
    private $passwordDecryption;

    public function setUp()
    {
        parent::setUp();
        $userRequest = (object)[
            'password' => null
        ];
        $this->passwordEncryption = new PasswordValueObject($userRequest);

        $userRecord = (object)[
            'password' => encrypt('password')
        ];
        $this->passwordDecryption = new PasswordValueObject($userRecord);
    }

    /**
     * @test
     */
    public function getEncryption()
    {
        $this->assertInternalType('string', $this->passwordEncryption->getEncryption());
    }

    /**
     * @test
     */
    public function getDecryption()
    {
        $this->assertInternalType('string', $this->passwordDecryption->getDecryption());
        $this->assertEquals($this->passwordDecryption->getDecryption(), 'password');
    }

}
