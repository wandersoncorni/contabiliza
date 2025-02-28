<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Application\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';
    /**
     * Atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'user_id',
        'nome',
        'telefone'
    ];
    /**
     * Valores padrao
     */
    protected $attributes = [
        'roles' => '["client"]',
    ];
    /**
     * Relacionamento com a tabela de usuários
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
