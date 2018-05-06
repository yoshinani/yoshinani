<?php
namespace Domain\ValueObjects;

use Illuminate\Support\Collection;

/**
 * Class SocialAccountValueObject
 * @package Domain\ValueObjects
 */
class SocialAccountValueObject
{
    private $socialAccounts;

    /**
     * SocialAccountValueObject constructor.
     * @param Collection $socialAccountRecord
     */
    public function __construct(Collection $socialAccountRecord)
    {
        $this->socialAccounts = $socialAccountRecord;
    }

    /**
     * @return Collection
     */
    public function getSocialAccounts(): Collection
    {
        return $this->socialAccounts;
    }
}
