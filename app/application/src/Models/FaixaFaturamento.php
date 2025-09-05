<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Application\Models\RegimeTributario;

class FaixaFaturamento extends Model
{
    use HasFactory;

    protected $table = "faixas_faturamento";

    public $timestamps = false;
    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'id',
        'regime_tributario_id',
        'licensed_id',
        'descricao',
        'hash',
    ];

    protected $hidden = [
        'created_at',
        'hash',
        'ativo'
    ];
    /**
     * Insere valores padrão
     */
    public function setDescricaoAttribute($value)
    {
        $this->attributes['descricao'] = $value;
        $this->attributes['hash'] = sha1($value);
    }

    public function regimeTributario()
    {
        return $this->belongsTo(RegimeTributario::class, 'regime_tributario_id');
    }
}