<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use App\Application\Models\Empresa;

class Departamento extends Model
{
    protected $table = "socios";
    
    protected $fillable = [
        'id',
        'licensed_id',
        'nome',
        'descricao',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
