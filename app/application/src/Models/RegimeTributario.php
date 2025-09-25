<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegimeTributario extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'regimes_tributarios';

    protected $fillable = ['id', 'descricao'];
}
