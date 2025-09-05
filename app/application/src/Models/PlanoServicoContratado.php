<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;

class PlanoServicoContratado extends Model
{

    protected $table = "planos_servicos_contratados";

    protected $fillable = [
        'id',
        'client_id',
        'empresa_id',
        'plano',
        'pagamento',
        'ativo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'plano' => 'array',
        'pagamento' => 'array',
    ];
}
