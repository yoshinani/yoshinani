<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Infrastructure\Interfaces\AuthRepositoryInterface;

/**
 * Class ManualController
 * @package App\Http\Controllers\Auth
 */
class ManualController extends Controller
{
    private $authRepository;
    private $authService;

    /**
     * ManualController constructor.
     * @param AuthRepositoryInterface $authRepository
     * @param AuthService $authService
     */
    public function __construct(
        AuthRepositoryInterface $authRepository,
        AuthService $authService
    )
    {
        $this->authRepository = $authRepository;
        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerEdit()
    {
        return view('auth.register.edit');
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmationRegister(RegisterRequest $request)
    {
        $request->flash();
        return view('auth.register.confirmation');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeRegister(Request $request)
    {
        $oldRequest = $request->old();
        $this->authRepository->registerUser($oldRequest);
        $userEntity = $this->authRepository->findUser($oldRequest);
        $userPasswordEntity = $this->authRepository->getUserPassword($userEntity->getUserId());
        $this->authService->login($oldRequest, $userEntity, $userPasswordEntity);
        return redirect()->to('/home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginEdit()
    {
        return view('auth.login.edit');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $request->flash();
        $oldRequest = $request->old();
        $userEntity = $this->authRepository->findUser($oldRequest);
        $userPasswordEntity = $this->authRepository->getUserPassword($userEntity->getUserId());
        $this->authService->login($oldRequest, $userEntity, $userPasswordEntity);
        return redirect()->to('/home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/login');
    }
}
