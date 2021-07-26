<?php

namespace App\Http\Middleware\Tenant;

use App\Http\Middleware\EncryptCookies;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;


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
        $manager = app(ManagerTenant::class);
        $tenantId = $this->getTenantId();

        if($tenantId){
            $company = $this->getCompany($tenantId);
            if (!$company && $request->url() != route('404.tenant') && $request->url() != route('login')) {
                return redirect()->route('404.tenant');
            }else if($company && $request->url() != route('404.tenant')){
                $manager->setConnection($company);
            }
        }
        return $next($request);
    }

    public function getCompany($tenantId){
        if($tenantId){
            return Company::where('cnpj', $tenantId)->first();
        }else{
            return false;
        }
    }

    public function getTenantId()
    {
        if(Cookie::has('cnpj')){

            if(strlen(Cookie::get('cnpj')) > 20){
                return explode('|', Crypt::decryptString(Cookie::get('cnpj')))[1];
            }else{
                return Cookie::get('cnpj');
            }
        }else {
            return false;
        }
    }
}
