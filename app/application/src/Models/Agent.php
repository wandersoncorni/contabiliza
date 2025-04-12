<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'agents';

    protected $fillable = [
        'client_id',
        'people_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }
    public function getClientNameAttribute()
    {
        return $this->client->name;
    }
    public function getPeopleNameAttribute()
    {
        return $this->people->name;
    }
}
