<?php

namespace App\Application\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Licenciado extends Model
{
    use HasFactory;

    protected $table="licenciados";

    protected $fillable = [
        'nome'
    ];
}
