<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Models\PlanoCategoriaServico;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlanoServico extends Model
{
    use HasFactory;

    protected $table="planos_servicos";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'licensed_id',
        'nome',
        'descricao',
        'ativo',
        'cor',
        'posicao',
    ];
    protected $hidden = [
        'licensed_id',
    ];
    /**
     * Relacionamento com a tabela plano_servico_faixa_faturamento
     * A faixa de faturamento determina o preço do plano
     */
    public function planoServicoFaixasFaturamento(): HasMany
    {
        return $this->hasMany(PlanoServicoFaixaFaturamento::class);
    }
    /**
     * Lista os serviços de um plano tendo como base atabela de
     * relacionamento
     */
    public function servicos(): HasMany
    {
        return $this->hasMany(PlanoCategoriaServico::class)->with('servico:id,nome');
    }
    /**
     * 
     */
    public function listaServicos(): BelongsToMany
    {
        return $this->BelongsToMany(Servico::class, PlanoCategoriaServico::class);
    }
    /**
     * Lista as categorias de um plano
     */
    public function categoriasPlano(): BelongsToMany
    {
        return $this->belongsToMany(CategoriaServico::class, PlanoCategoriaServico::class);
    }
}
