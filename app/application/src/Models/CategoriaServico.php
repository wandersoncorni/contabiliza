<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Application\Models\Servico;
use App\Application\Models\PlanoCategoriaServico;

class CategoriaServico extends Model
{
    use HasFactory;

    protected $table="categorias_servicos";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'licensed_id',
    ];

    protected $hidden = [        
        'pivot'
    ];

    public function servicos()
    {
        return $this->hasManyThrough(Servico::class, PlanoCategoriaServico::class);
    }

    public function listarServicos()
    {
        return $this->hasMany(Servico::class);
    }
}
