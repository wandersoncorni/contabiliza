<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanoServicoValor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "planos_servicos_valores";
    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'licensed_id',
        'plano_servico_id',
        'regime_tributario_id',
        'area_atividade_id',
        'periodicidade_id',
        'rotulo',
        'valor',
    ];

    protected $hidden = [
        'created_at',
    ];

    protected $casts = [
        'valor' => 'float',
    ];
}