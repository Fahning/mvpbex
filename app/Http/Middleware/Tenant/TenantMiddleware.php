<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Models\User;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $manager =  app(ManagerTenant::class);

        if($manager->domainIsMain())
            return $next($request);

        $company = $this->getCompany($request->getHost());
        if (!$company && $request->url() != route('404.tenant')) {
            return redirect()->route('404.tenant');
        }else if($request->url() != route('404.tenant')){
            $manager->setConnection($company);
        }
        return $next($request);
    }

    public function getCompany($domain){
        return Company::where('domain', $domain)->first();
    }
}
