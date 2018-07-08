<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Domain\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;

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
        return view('home.user');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function withdrawal(): RedirectResponse
    {
        $userEntity = $this->authService->getLoginUser();
        $this->authService->withdrawal($userEntity);

        return redirect('/');
    }
}
