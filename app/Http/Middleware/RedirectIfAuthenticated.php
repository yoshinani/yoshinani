<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthManager;

class RedirectIfAuthenticated
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->authManager->guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
