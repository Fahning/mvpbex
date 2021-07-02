<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCtes extends Model
{
    use HasFactory;

    protected $table = 'tabela_ctes';

    public function getCtrcAttribute()
{
    return $this->attributes['name'];
}
}
