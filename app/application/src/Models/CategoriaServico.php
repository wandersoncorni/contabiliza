<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaServico extends Model
{
    use HasFactory;

    protected $table="categorias_servicos";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
    ];

    public function servico()
    {
        return $this->hasMany(Servico::class);
    }
}
