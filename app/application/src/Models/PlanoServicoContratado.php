<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoServicoContratado extends Model
{
    use HasFactory;

    protected $table = "planos_servicos_contratados";

    public const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'id_empresa',
        'plano',
    ];
}
