<?php

namespace App\AccessControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'parent_id',
        'label'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permission(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }
}
