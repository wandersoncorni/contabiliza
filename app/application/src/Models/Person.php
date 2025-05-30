<?php

namespace App\Application\Models;

use App\AccessControl\Models\User;
use App\Application\Models\Licensed;
use App\AccessControl\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';
    /**
     * Atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'roles',
        'licensed_id',
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
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    /**
     * Lista os agentes de um cliente
     */
    public function agents(): hasMany
    {
        return $this->hasMany(Person::class, 'client_id');
    }
    /**
     * Lista o cliente ao qual o agente pertence
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'id', 'client_id');
    }

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class);
    }

    public function getRolesNamesAttribute()
    {
        if (empty($this->roles)) return [];

        return Role::whereIn('label', $this->roles)
                   ->pluck('name')
                   ->toArray();
    }
}
