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

class PlanoServicoCategoria extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table="plano_servico_categoria";

    protected $fillable = [
        'plano_servico_id',
        'categoria_servico_id',
        'servico_id',
        'licensed_id'
    ];

    protected $hidden = [
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

    public function valorServico(): BelongsTo
    {
        return $this->belongsTo(ServicoValor::class, 'servico_id', 'servico_id');
    }
}
