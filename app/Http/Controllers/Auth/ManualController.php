<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

class ManualController extends Controller
{
    public function registerEdit()
    {
        return view('auth.register.edit');
    }

    public function confirmationRegister(RegisterRequest $request)
    {
        $request->flash();
        return view('auth.register.confirmation');
    }

    public function completeRegister(Request $request)
    {
        $oldRequest = $request->old();
        //TODO: ユーザ作成の処理
        return redirect()->to('/home');
    }
}
