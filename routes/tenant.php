<?php

use App\Http\Controllers\Tenant\CompanyController;
use Illuminate\Support\Facades\Route;



Route::get('/', function (){
    return 'tenant';
});


Route::get('company/store', [CompanyController::class, 'store'])->name('company.store');
