<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\{
    Companies,
    Components\Operacional\AnaliseDeCustos,
    Components\Operacional\DefineMetaCustos,
    DefinirMeta,
    FarolFaturamento,
    Financeiro,
    Movimentacoes,
    Operacional
};


Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::view('/404-tenant','errors.404-tenant')->name('404.tenant');

Route::middleware(['auth'])
    ->get('/', FarolFaturamento::class)
    ->name('dashboard');

Route::middleware(['auth'])
    ->get('/movimentacoes', Movimentacoes::class)
    ->name('movimentacoes');


Route::middleware(['auth'])
    ->get('/inventario', Operacional::class)
    ->name('inventario');

Route::middleware(['auth'])
    ->get('/analise-custos', AnaliseDeCustos::class)
    ->name('analise-custos');
Route::middleware(['auth'])
    ->get('/definir-meta-custos', DefineMetaCustos::class)
    ->name('meta-custos');

Route::middleware(['auth'])
    ->get('/definir-meta', DefinirMeta::class)
    ->name('definir-meta');

Route::middleware(['auth'])
    ->get('/financeiro', Financeiro::class)
    ->name('financeiro');

//Route::middleware(['auth', 'menu.admin'])->get('companies', Companies::class)
//    ->name('companies');
