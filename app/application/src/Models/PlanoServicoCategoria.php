<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Application\Models\Servico;
use App\Application\Models\Plano;

class PlanoServicoCategoria extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table="plano_servico_categoria";

    protected $fillable = [
        'id_planos_servicos',
        'id_servicos',
        'ativo'
    ];

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }
}
