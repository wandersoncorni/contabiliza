<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Models\PlanoServicoCategoria;

class Plano extends Model
{
    use HasFactory;

    protected $table="planos_servicos";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'valor',
        'ativo',
    ];

    public function planoCategoria(): HasMany
    {
        return $this->hasMany(PlanoServicoCategoria::class);
    }
}
