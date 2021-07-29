<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Cookie;

class Authenticate extends Middleware
{

    protected function authenticate($request, array $guards)
    {
        $manager = app(ManagerTenant::class);

        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if((Company::where('hash_auth',Cookie::get('_HS-AT'))->exists())){
                return $this->auth->shouldUse($guard);
            }
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
