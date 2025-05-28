<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Models\PlanoServico;

class Servico extends Model
{
    use HasFactory;

    protected $table="servicos";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'descricao',
    ];

    public function plano(): HasMany
    {
        return $this->hasMany(PlanoServico::class);
    }
}
