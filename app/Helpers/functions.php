<?php


use Carbon\Carbon;

if (! function_exists('formatReceita')) {
    function formatReceita($value){
        $value = intval($value);
        return 'R$: '.strval(number_format($value,2,",","."));
    }
}

if (! function_exists('formatPorcent')) {
    function formatPorcent($value){
        $value = floatval($value);
        return number_format($value,2,".", '');
    }
}

if (! function_exists('monthToString')) {
    function monthToString($value){
        Carbon::setLocale('pt_BR');
        return ucfirst(Carbon::create(0, $value)->monthName);
    }
}


if (! function_exists('FormatDateBr')) {
    function FormatDateBr($value){
        Carbon::setLocale('pt_BR');
        return Carbon::create($value)->format('d/m/Y');
    }
}
