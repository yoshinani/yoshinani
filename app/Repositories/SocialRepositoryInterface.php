<?php

namespace App\Repositories;

interface SocialRepositoryInterface
{
    public function findSocialAccount($providerUserId, $provider);
    public function associationSocialAccount($providerUserId, $provider, $userId);
}