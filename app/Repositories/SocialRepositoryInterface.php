<?php

namespace App\Repositories;

interface SocialRepositoryInterface
{
    public function findSocialAccount();
    public function associationSocialAccount();
}