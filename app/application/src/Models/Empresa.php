<?php

namespace App\Application\Models;

use App\Application\Models\Socio;
use Illuminate\Database\Eloquent\Model;
use App\Application\Models\PlanoServicoCategoria;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";

    protected $appends = ['status_label', 'situacao_label'];

    protected $fillable = [
        'id',
        'cliente_id',
        'area_atividade_id',
        'bairro',
        'capital_social',
        'cep',
        'client_id',
        'cnae_id',
        'cnpj',
        'complemento',
        'data_abertura',
        'estado',
        'faixa_faturamento_id',
        'inscricao_estadual',
        'inscricao_municipal',
        'localidade',
        'logradouro',
        'natureza_juridica_id',
        'nome_fantasia',
        'numero',
        'numero_inscricao',
        'razao_social',
        'regime_tributario_id',
        'situacao',
        'status',
        'tipo_inscricao',
        'total_funcionarios',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function plano(): BelongsTo
    {
        return $this->belongsTo(PlanoServicoCategoria::class)->where('ativo', true);
    }
    /**
     * Lista os socios de uma empresa
     */
    public function socios()
    {
        return $this->belongsToMany(Socio::class, 'empresa_socio', 'empresa_id', 'socio_id');
    }
    /**
     * Rotulos para status
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            return [
                0 => 'Rejeitado',
                1 => 'Aprovado',
                2 => 'Pendente',
                3 => 'Cancelado',
            ][$this->status] ?? 'Desconhecido';
        });
    }
    /**
     * Rotulos para status
     */
    protected function situacaoLabel(): Attribute
    {
        return Attribute::get(function () {
            return [
                0 => 'Nula',
                1 => 'Ativa',
                2 => 'Suspensa',
                3 => 'Baixada',
                4 => 'Em processo de inscrição',
            ][$this->situacao] ?? 'Desconhecido';
        });
    }
}
