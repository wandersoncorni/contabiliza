<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'created_at',
    ];

    protected $casts = [
        'valor' => 'float',
    ];

    public function faixaFaturamento(): BelongsTo
    {
        return $this->belongsTo(FaixaFaturamento::class, 'faixa_faturamento_id');
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(PlanoServico::class, 'plano_servico_id');
    }
}