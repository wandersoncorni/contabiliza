<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Models\PlanoServicoCategoria;

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
        'valor_mensal',
        'valor_anual',
        'ativo',
    ];
    protected $hidden = [
        'licensed_id',
    ];

    public function categoriasServicos(): HasMany
    {
        return $this->hasMany(PlanoServicoCategoria::class);
    }
}
