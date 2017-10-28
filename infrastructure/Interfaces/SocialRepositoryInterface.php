<?php

namespace Infrastructure\Interfaces;

interface SocialRepositoryInterface
{
    public function findSocialAccount($providerUserId, $provider);
    public function associationSocialAccount($providerUserId, $provider, $userId);
}