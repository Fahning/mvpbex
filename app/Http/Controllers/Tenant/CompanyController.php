<?php

namespace App\Http\Controllers\Tenant;

use App\Events\CompanyCreated;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {
        $company = $this->company->create([
            'name' => 'Empresa x' . Str::random(5),
            'cnpj' => Str::random(10),
            'domain' => Str::random(5).'empresax.com',
            'db_database' => 'db_x'.Str::random(5),
            'db_hostname' => 'mysql',
            'db_username' => 'root',
            'db_password' => 'root'
        ]);

        event(new CompanyCreated($company));

        dd($company);
    }
}
