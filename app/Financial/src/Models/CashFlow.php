<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashFlow extends Model
{
    use HasFactory;

    protected $table = 'cash_flow';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'company_id',
        'chart_of_account_id',
        'transaction_id',
        'installment_id',
        'account_id',
        'amount',
        'paid_amount',
        'interest',
        'discount',
        'type',
        'transaction_date',
        'description',
    ];

    protected $hidden = [
        'licensed_id',
        'company_id',
        'chart_of_account_id',
        'transaction_id',
        'installment_id',
        'account_id',
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

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class, 'installment_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}