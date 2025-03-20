<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Application\Models\People;
use App\Application\Models\Client;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeopleClient extends Model
{
    use HasFactory;
    
    protected $table = 'people_client';

    protected $fillable = [
        'people_id',
        'client_id'
    ];

    public function people(): HasMany
    {
        return $this->hasMany(People::class);
    }

    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
