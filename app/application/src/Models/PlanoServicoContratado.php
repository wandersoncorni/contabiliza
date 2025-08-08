<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoServicoContratado extends Model
{
    use SoftDeletes;

    protected $table = "planos_servicos_contratados";

    protected $fillable = [
        'id',
        'client_id',
        'empresa_id',
        'plano',
        'ativo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'plano' => 'array',
    ];
}
