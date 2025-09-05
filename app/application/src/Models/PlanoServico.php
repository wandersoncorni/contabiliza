<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Models\PlanoServicoCategoria;
use App\Application\Models\PlanoServicoValor;

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
     * Relacionamento com a tabela plano_servico_categoria.
     * Representa o plano de servico e suas categorias com seus servicos
     */
    public function plano(): HasMany
    {
        return $this->hasMany(PlanoServicoCategoria::class, 'plano_servico_id', 'id');
    }

    public function valorPlanoServico(): HasMany
    {
        return $this->hasMany(PlanoServicoValor::class, 'plano_servico_id', 'id');
    }

    public function faixasFaturamento(): HasMany
    {
        return $this->hasMany(PlanoServicoFaixaFaturamento::class, 'plano_servico_id', 'id');
    }
    /**
     * Relacionamento com as tabelas categoria e servico
     */
    public function servico(): HasMany
    {
        return $this->hasMany(PlanoServicoCategoria::class, 'plano_servico_id', 'id');
    }

    public function servicos()
    {
        return $this->hasManyThrough(Servico::class, PlanoServicoCategoria::class, 'plano_servico_id', 'id', 'id', 'servico_id');
    }

    public function valoresServicos()
    {
        return $this->hasMany(ServicoValor::class, 'plano_servico_id');
    }

    public function categorias(): HasMany
    {
        return $this->hasMany(PlanoServicoCategoria::class, 'plano_servico_id', 'id');
    }
}
