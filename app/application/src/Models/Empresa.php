<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empresa extends Model
{
    use HasFactory;

    protected $table="empresas";

    protected $fillable = [
        'id',
        'cliente_id',
        'cnae',
        'nome',
        'cnpj',
        'capital_social',
        'area',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'estado',
        'municipio',
        'inscricao_municipal',
        'inscricao_estadual',
        'data_abertura',
        'tipo_inscricao',
        'numero_inscricao',
        'natureza_juridica',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function plano(): BelongsTo
    {
        return $this->belongsTo(PlanoServicoCategoria::class)
        ->where('ativo', true);
    }
}