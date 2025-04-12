<?php

namespace App\AccessControl\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail  as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\AccessControl\Services\RBACService;
use App\Application\Models\People;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmail;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * Os atributos que devem ser ocultados para arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    /**
     * Valores padrao
     */
    protected $attributes = [
        'active' => 0,
    ];
    /**
     * Valida a permissao do usupario para uma acao
     * @param String $permissao
     */
    public function hasPermission(string $permission): bool
    {
        $rbacService = app(RBACService::class);
        $userRoles = !is_array($this->person->roles) ? json_decode($this->person->roles) : $this->person->roles ;
        foreach ($userRoles as $role) {
            if ($rbacService->hasPermission($role, $permission)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Relacionamento com a tabela de pessoas
     * @return Object
     */
    public function person(): HasOne
    {
        return $this->hasOne(People::class);
    }
}
