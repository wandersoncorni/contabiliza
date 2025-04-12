<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\AccessControl\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';
    /**
     * Atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'user_id',
        'licenciado_id',
        'name',
        'phone',
        'roles'
    ];
    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'roles' => 'array',
    ];
    /**
     * Relacionamento com a tabela de usuários
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function agent(): HasMany
    {
        return $this->hasMany(Agent::class);
    }
}
