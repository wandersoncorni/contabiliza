<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'people_id',
    ];

    public function people(): HasMany
    {
        return $this->hasMany(People::class);
    }

    public function agent(): HasMany
    {
        return $this->hasMany(Agent::class);
    }
}
