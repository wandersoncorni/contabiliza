<?php

namespace App\AccessControl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'name',
        'label',
    ];

    public function action()
    {
        return $this->hasMany(Permission::class,'action_id');
    }

    public function role()
    {
        return $this->belongsToMany(Permission::class,'role_id');
    }
}
