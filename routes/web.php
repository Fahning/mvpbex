<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\{
    Companies
};

Route::get('/', function () {
    return view('welcome');
});
Route::view('/404-tenant','errors.404-tenant')->name('404.tenant');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('livewire.farol-faturamento');
})->name('dashboard');


Route::get('companies', Companies::class);
