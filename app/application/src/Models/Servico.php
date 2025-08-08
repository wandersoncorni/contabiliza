<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Models\PlanoServico;
use App\Application\Models\ServicoValor;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Servico extends Model
{
    use HasFactory;

    protected $table="servicos";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'licensed_id',
    ];

    public function plano(): HasMany
    {
        return $this->hasMany(PlanoServico::class);
    }

    public function valor(): HasOne
    {
        return $this->hasOne(ServicoValor::class, 'servico_id');
    }

    public function valores()
    {
        return $this->hasMany(ServicoValor::class, 'servico_id');
    }
}
