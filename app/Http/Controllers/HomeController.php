<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userEntity = [
            'id'       => 1,
            'email'    => 'test@test.test',
            'name'     => 'testName',
            'nickname' => 'testNickName',
            'password' => encrypt('password'),
            'active'   => 1
        ];
        return view('home', compact('userEntity'));
    }
}
