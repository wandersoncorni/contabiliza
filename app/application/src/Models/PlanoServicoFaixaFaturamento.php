<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanoServicoFaixaFaturamento extends Model
{
    use HasFactory;

    protected $table = "plano_servico_faixa_faturamento";

    public $timestamps = false;
    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'plano_servico_id',
        'faixa_faturamento_id',
        'valor',
        'ativo',
    ];

    protected $hidden = [
        'plano_servico_id',
        'created_at',
        'ativo',
    ];

    protected $casts = [
        'valor' => 'float',
    ];

    public function plano(): BelongsTo
    {
        return $this->belongsTo(PlanoServico::class, 'plano_servico_id');
    }

    public function valoresFaixasFaturamento(): BelongsTo
    {
        return $this->belongsTo(PlanoServico::class, 'id', 'plano_servico_id');
    }
}