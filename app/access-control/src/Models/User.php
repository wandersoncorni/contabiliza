<?php

namespace App\AccessControl\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\AccessControl\Services\RBACService;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'password'
    ];

    /**
     * Os atributos que devem ser ocultados para arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        foreach($this->roles as $role){
            if($rbacService->hasPermission($this->role, $permission)){
                return true;
            }
        }
        return false;
    }
}
