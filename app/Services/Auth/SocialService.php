<?php

namespace App\Services\Auth;

use Auth;
use Exception;
use Laravel\Socialite\Contracts\User;

class SocialService
{
    public function existsItems(User $providerUser)
    {
        if (is_null($providerUser->getName()) || is_null($providerUser->getEmail())) {
            throw new Exception('Name or email is missing');
        }
        return true;
    }

    public function socialLogin($userId)
    {
        /*
         * TODO
         * 複数のsocialAccountを利用していた場合providerUserIdのConflictが考えられる
         * ProviderUserIdとProviderNameで検索をかけて該当するレコードを取得する
         * そのUserIdを利用してログインするように変更する
         */
        if (!Auth::loginUsingId($userId)) {
            throw new Exception('It is a User that does not exist');
        }
    }
}