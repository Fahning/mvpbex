<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\{
    Companies
};


Route::view('/404-tenant','errors.404-tenant')->name('404.tenant');

Route::middleware(['auth'])->get('/', function () {
    return view('livewire.farol-faturamento');
})->name('dashboard');

Route::middleware(['auth'])->get('/inventario', function () {
    return view('livewire.operacional');
})->name('inventario');
Route::middleware(['auth'])->get('/analise-custos', function () {
    return view('livewire.components.operacional.analise-de-custos');
})->name('analise-custos');


Route::middleware(['auth'])->get('/definir-meta', function () {
    return view('livewire.definir-meta');
})->name('definir-meta');

Route::middleware(['auth'])->get('/financeiro', function () {
    return view('livewire.financeiro');
})->name('financeiro');

Route::middleware(['auth', 'menu.admin'])->get('companies', Companies::class)
    ->name('companies');
