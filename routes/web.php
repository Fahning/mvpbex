<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\{
    Companies
};


Route::view('/404-tenant','errors.404-tenant')->name('404.tenant');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('livewire.farol-faturamento');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/operacional', function () {
    return view('livewire.operacional');
})->name('operacional');

Route::middleware(['auth:sanctum', 'verified'])->get('/definir-meta', function () {
    return view('livewire.definir-meta');
})->name('definir-meta');

Route::middleware(['auth:sanctum', 'verified'])->get('/financeiro', function () {
    return view('livewire.financeiro');
})->name('financeiro');

Route::middleware(['auth:sanctum', 'verified'])->get('companies', Companies::class)
    ->name('companies');
