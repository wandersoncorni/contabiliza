<?php

namespace App\AccessControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use hasFactory;

    protected $fillable = [
        'name',
        'label'
    ];

    public function role()
    {
        return $this->belongsToMany(Permission::class,'role_id');
    }

    public function asset()
    {
        return $this->belongsToMany(Permission::class,'asset_id');
    }
}
