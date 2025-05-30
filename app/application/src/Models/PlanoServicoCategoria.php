<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Application\Models\Servico;
use App\Application\Models\CategoriaServico;

class PlanoServicoCategoria extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table="plano_servico_categoria";

    protected $fillable = [
        'plano_servico_id',
        'categoria_servico_id',
        'servico_id',
        'ativo'
    ];

    protected $hidden = [
        'plano_servico_id',
        'categoria_servico_id',
        'servico_id',
        'ativo',
        'created_at'
    ];

    public function plano(): BelongsTo
    {
        return $this->belongsTo(PlanoServico::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaServico::class, 'categoria_servico_id', 'id');
    }

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }
}
