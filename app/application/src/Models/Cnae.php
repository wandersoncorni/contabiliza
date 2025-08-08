<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cnae extends Model
{ 
    use HasFactory;

    protected $table = 'cnae';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'codigo',  
        'descricao',
    ];

    public function empresa(): HasMany
    {
        return $this->hasMany(Empresa::class, 'cnae_id', 'id');
    }
}
