<?php
namespace Domain\Services\Auth;

use Exception;
use Domain\Specification\SocialLoginSpecification;
use Domain\Entities\UserEntity;
use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
use Domain\Entities\SocialUserAccountEntity;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;
use Infrastructure\Interfaces\Auth\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialService
 * @package Domain\Services\Auth
 */
class SocialService
{
    private $socialLoginSpecification;
    private $manualRepository;
    private $socialRepository;

    /**
     * SocialService constructor.
     * @param SocialLoginSpecification $socialLoginSpecification
     * @param ManualRepositoryInterface $manualRepository
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        SocialLoginSpecification $socialLoginSpecification,
        ManualRepositoryInterface $manualRepository,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->socialLoginSpecification = $socialLoginSpecification;
        $this->manualRepository         = $manualRepository;
        $this->socialRepository         = $socialRepository;
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return bool
     * @throws Exception
     */
    public function socialLogin(string $driverName, SocialUser $socialUser): bool
    {
        $userEntity              = $this->socialRegisterUser($socialUser);
        $socialUserAccountEntity = $this->synchronizeSocialAccount($driverName, $socialUser, $userEntity);

        return $this->socialLoginSpecification->isCondition($driverName, $socialUser, $socialUserAccountEntity, $userEntity);
    }

    /**
     * @param SocialUser $socialUser
     * @return RegisterUserEntity
     * @throws Exception
     */
    protected function socialRegisterUser(SocialUser $socialUser): RegisterUserEntity
    {
        $email      = $socialUser->getEmail();
        $userEntity = $this->manualRepository->getUser($email);
        if (is_null($userEntity)) {
            $this->socialLoginSpecification->isRequiredInfo($socialUser);
            $userEntity = $this->socialRepository->registerUser($socialUser);
        }

        return $userEntity;
    }

    /**
     * @param string $driverName
     * @param SocialUser $socialUser
     * @param RegisterUserEntity $userEntity
     * @return SocialUserAccountEntity
     */
    protected function synchronizeSocialAccount(string $driverName, SocialUser $socialUser, RegisterUserEntity $userEntity): SocialUserAccountEntity
    {
        $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userEntity->getId(), $driverName, $socialUser);
        if (is_null($socialUserAccountEntity)) {
            $this->socialRepository->synchronizeSocialAccount($userEntity->getId(), $driverName, $socialUser);
            $socialUserAccountEntity = $this->socialRepository->findSocialAccount($userEntity->getId(), $driverName, $socialUser);
        }

        return $socialUserAccountEntity;
    }
}
