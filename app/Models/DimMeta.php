<?php

namespace App\Models;



use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;


class DimMeta extends Model
{
    protected $table = 'dim_meta';
    protected $primaryKey = ['ANO', 'MES'];
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = ['ANO', 'MES', 'META', 'META_COLETA', 'META_ENTREGA', 'META_TRANSFERENCIA', 'META_CUSTO_GERAL'];
}
