<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Application\Models\Servico;

class ServicoValor extends Model
{
    use HasFactory;

    protected $table="servicos_valores";

    public $timestamps = false;

    protected $fillable = [
        'servico_id',
        'valor',
        'condicoes'
    ];

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }

    protected $casts = [
        'condicoes' => 'array',
        'valor' => 'array',
    ];
}
