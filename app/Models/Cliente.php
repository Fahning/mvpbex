<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'bexsal_reports.clientes';

    protected $primaryKey = 'cliente';

    protected $keyType = 'string';
}
