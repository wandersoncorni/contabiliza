<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaturezaJuridica extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'naturezas_juridicas';

    protected $fillable = ['id','codigo', 'descricao'];
}
