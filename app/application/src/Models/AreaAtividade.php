<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaAtividade extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'areas_atividade';

    protected $fillable = ['descricao'];
}
