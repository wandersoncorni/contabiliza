<?php

namespace App\AccessControl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'role_id',
        'permission_id',
        'asset_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
