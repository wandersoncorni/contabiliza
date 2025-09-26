<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'company_id',
        'chart_of_account_id',
        'person_id',
        'payment_condition_id',
        'type',
        'amount',
        'transaction_date',
        'payment_date',
        'due_date',
        'description',
        'status',
    ];

    protected $hidden = [
        'licensed_id',
        'company_id',
        'chart_of_account_id',
        'person_id',
        'payment_condition_id',
    ];

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'company_id');
    }

    public function chartOfAccount(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'chart_of_account_id');
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(PeopleCompany::class, 'person_id');
    }

    public function paymentCondition(): BelongsTo
    {
        return $this->belongsTo(PaymentCondition::class, 'payment_condition_id');
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'transaction_id');
    }

    public function cashFlows(): HasMany
    {
        return $this->hasMany(CashFlow::class, 'transaction_id');
    }
}