<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCtes extends Model
{
    protected $table = 'tabela_ctes';
    public $timestamps = false;


    public function scopeSearch($query, $filtros)
    {
        $query->when($filtros['ano'], function($query) use($filtros) {
            $query->where('ano', $filtros['ano']);
        });
        $query->when($filtros['mes'], function($query) use($filtros) {
            $query->where('mes', $filtros['mes']);
        });
        $query->when($filtros['searchSegmentos'], function($query) use($filtros) {
            $query->whereIn('segmento',$filtros['searchSegmentos']);
        });
        $query->when($filtros['searchBase'], function($query) use($filtros) {
            $query->whereIn('und_receptora', $filtros['searchBase']);
        });
        $query->when($filtros['searchCliente'], function($query) use($filtros) {
            $query->where('nome_pagador', $filtros['searchCliente']);
        });
    }
}
