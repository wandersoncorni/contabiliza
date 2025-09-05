<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaSocio extends Model
{
    protected $table="empresa_socio";

    const UPDATED_AT = null;

    protected $fillable = [
        'empresa_id',
        'socio_id',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
    ];
}
