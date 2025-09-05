<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use App\Application\Models\Empresa;

class Socio extends Model
{
    protected $table = "socios";
    
    protected $fillable = [
        'id',
        'client_id',
        'empresa_id',
        'bairro',
        'cep',
        'complemento',
        'cpf',
        'email',
        'estado',
        'estado_civil',
        'logradouro',
        'localidade',
        'municipio',
        'nome',
        'numero',
        'participacao',
        'pro_labore',
        'profissao',
        'regime_bens',
        'resp_rf',
        'telefone',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function company()
    {
        return $this->belongsToMany(Empresa::class, 'empresa_socio', 'empresa_id', 'socio_id');
    }
}
