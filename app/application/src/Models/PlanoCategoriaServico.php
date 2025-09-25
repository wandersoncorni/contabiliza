<?php
/**
 * Model de relacionamento entre PlanoServico, CategoriaServico e servico
 * Um plano tem uma ou mais categorias que possuem um ou mais servicos
 * 
 */
namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Application\Models\Servico;
use App\Application\Models\CategoriaServico;

class PlanoCategoriaServico extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table="plano_categoria_servico";

    protected $fillable = [
        'plano_servico_id',
        'categoria_servico_id',
        'servico_id',
        'observacao',
        'condicoes',
        'valor',
    ];

    protected $hidden = [
        'created_at',
    ];

    protected $casts = [
        'condicoes' => 'array',
    ];

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }
}
