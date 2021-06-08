<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::view('/404-tenant','errors.404-tenant')->name('404.tenant');
