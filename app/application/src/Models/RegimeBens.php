<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class RegimeBens extends Model
{
    use HasFactory;

    protected $table="regimes_bens";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
    ];
}
