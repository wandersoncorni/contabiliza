<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Installment extends Model
{
    use HasFactory;

    protected $table = 'installments';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'transaction_id',
        'installment_number',
        'amount',
        'due_date',
        'payment_date',
        'status',
    ];

    protected $hidden = [
        'licensed_id',
        'transaction_id',
    ];

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function cashFlows(): HasMany
    {
        return $this->hasMany(CashFlow::class, 'installment_id');
    }
}