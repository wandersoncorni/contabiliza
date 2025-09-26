<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentCondition extends Model
{
    use HasFactory;

    protected $table = 'payment_conditions';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'installment_interval_id',
        'description',
        'payment_type',
        'weekend_due_date',
        'display_in',
        'issues_invoice',
        'allows_down_payment',
    ];

    protected $hidden = [
        'licensed_id',
        'installment_interval_id',
    ];

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }

    public function installmentInterval(): BelongsTo
    {
        return $this->belongsTo(InstallmentInterval::class, 'installment_interval_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payment_condition_id');
    }
}