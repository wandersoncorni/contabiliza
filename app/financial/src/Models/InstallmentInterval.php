<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallmentInterval extends Model
{
    use HasFactory;

    protected $table = 'installment_intervals';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'installment',
        'interval',
        'percentage',
    ];

    protected $hidden = [
        'licensed_id',
    ];

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }

    public function paymentConditions(): HasMany
    {
        return $this->hasMany(PaymentCondition::class, 'installment_interval_id');
    }
}