<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Domain\Services\AuthService;

class UserController extends Controller
{
    private $authService;

    /**
     * Create a new controller instance.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loginUser  = $this->authService->getLoginUser();
        $userEntity = $loginUser->toArray();

        return view('home.user', compact('userEntity'));
    }
}
