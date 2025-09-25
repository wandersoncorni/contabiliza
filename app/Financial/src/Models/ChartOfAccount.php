<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $table = 'chart_of_accounts';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'code',
        'name',
        'type',
        'parent_id',
        'company_id',
    ];

    protected $hidden = [
        'licensed_id',
        'company_id',
        'parent_id',
    ];

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'company_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function cashFlows(): HasMany
    {
        return $this->hasMany(CashFlow::class, 'chart_of_account_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'chart_of_account_id');
    }
}