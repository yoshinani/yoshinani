<?php

namespace Tests\Unit;

use Domain\ValueObjects\PasswordValueObject;
use Tests\TestCase;

class PasswordValueObjectTest extends TestCase
{
    private $password;

    /**
     * When there is a character string to be encrypted
     * 暗号化する文字列がある場合
     * @test
     */
    public function getEncryptionString()
    {
        $userRequest = (object)[
            'password' => 'password'
        ];
        $this->password = new PasswordValueObject($userRequest);

        $this->assertInternalType('string', $this->password->getEncryption());
    }

    /**
     * When there is no character string to be encrypted
     * 暗号化すべき文字列がない場合
     * @test
     */
    public function getEncryptionNull()
    {
        $userRequest = (object)[
            'password' => null
        ];
        $this->password = new PasswordValueObject($userRequest);

        $this->assertInternalType('string', $this->password->getEncryption());
    }

    /**
     * Case where password has already been registered
     * パスワードが既に登録されている場合
     * @test
     */
    public function getDecryptionString()
    {
        $userRecord = (object)[
            'password' => encrypt('password')
        ];
        $this->password = new PasswordValueObject($userRecord);

        $this->assertInternalType('string', $this->password->getDecryption());
        $this->assertEquals($this->password->getDecryption(), 'password');
    }

    /**
     * When the password is not registered
     * パスワードが登録されていない場合
     * @test
     */
    public function getDecryptionNull()
    {
        $userRecord = (object)[
            'password' => null
        ];
        $this->password = new PasswordValueObject($userRecord);

        $this->assertInternalType('string', $this->password->getDecryption());
        $this->assertEquals($this->password->getDecryption(), 'Unregistered');
    }


}
