<?php

namespace App\Application\Models;

use App\Application\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Licensed extends Model
{
    use HasFactory;

    protected $table="licensed";

    protected $fillable = [
        'id',
        'name'
    ];

    public function person(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
