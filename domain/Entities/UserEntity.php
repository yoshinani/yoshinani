<?php
namespace Domain\Entities;

use Domain\ValueObjects\NickNameValueObject;
use Domain\ValueObjects\PasswordValueObject;
use Domain\ValueObjects\TimeStampValueObject;
use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class RegisterUserEntity
 * @package Domain\Entities
 */
class UserEntity implements Arrayable
{
    private $id;
    private $user;
    private $nickname;
    private $password;
    private $timeStamp;

    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->user      = new UserValueObject($userRecord);
        $this->nickname  = new NickNameValueObject($userRecord);
        $this->timeStamp = new TimeStampValueObject();
    }

    /**
     * @param $userId
     */
    public function setId($userId)
    {
        $this->id = $userId;
    }

    /**
     * @param $userRecord
     */
    public function setPassword($userRecord)
    {
        $this->password = new PasswordValueObject($userRecord);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'         => $this->getId(),
            'email'      => $this->getEmail(),
            'name'       => $this->getName(),
            'nickname'   => $this->getNickName(),
            'password'   => $this->getDecryptionPassword(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->user->getName();
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickname->getNickName();
    }

    /**
     * @return string
     */
    public function getEncryptionPassword(): string
    {
        return $this->password->getEncryption();
    }

    /**
     * @return string
     */
    public function getDecryptionPassword(): string
    {
        return $this->password->getDecryption();
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->timeStamp->getNow();
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->timeStamp->getNow();
    }
}
