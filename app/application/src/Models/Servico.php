<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];
}
