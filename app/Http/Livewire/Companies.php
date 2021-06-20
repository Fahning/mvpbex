<?php

namespace App\Http\Livewire;

use App\Events\CompanyCreated;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public $name = '';
    public $cnpj = '';
    public $database = '';
    public $hostname = '';
    public $username = '';
    public $password = '';

    protected $rules = [
        'name' => 'required',
        'cnpj' => 'required',
        'database' => 'required',
        'hostname' => 'required',
        'username' => 'required'
    ];

    public function render()
    {
        $companies = Company::paginate(6);

        return view('livewire.companies', compact('companies'));
    }

    public function create()
    {

        $this->validate();

        $company = Company::create([
            'name' => $this->name,
            'cnpj' => $this->cnpj,
            'domain' => strtolower(str_replace(' ','',$this->name)).".mvpbex.local",
            'db_database' => $this->database,
            'db_hostname' => $this->hostname,
            'db_username' => $this->username,
            'db_password' => $this->password
        ]);
        event(new CompanyCreated($company));

        $this->name = '';
        $this->cnpj = '';
        $this->database = '';
        $this->hostname = '';
        $this->username = '';
        $this->password = '';

        dd($company->name . " Cadastrada");
    }

    public function edit()
    {
        dd("Editar");
    }
}
