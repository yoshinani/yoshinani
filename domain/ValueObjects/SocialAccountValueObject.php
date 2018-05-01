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
     * @return array
     */
    public function getDriverNames(): array
    {
        $driverNames = [];
        foreach ($this->socialAccounts as $account) {
            $driverNames[] = $account->driver_name;
        }
        return $driverNames;
    }

    /**
     * @return array
     */
    public function getSocialUserIds(): array
    {
        $socialUserIds = [];
        foreach ($this->socialAccounts as $account) {
            $socialUserIds[] = $account->social_user_id;
        }

        return $socialUserIds;
    }
}
