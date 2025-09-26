<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Application\Models\Empresa;
use App\Application\Models\Licensed;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'company_id',
        'bank_name',
        'bank_code',
        'agency',
        'account_number',
        'digit',
        'manager_name',
        'contact_phone',
        'account_type',
        'status',
        'pix_key',
        'integration_data',
        'notes',
        'licensed_id',
    ];

    protected $hidden = [
        'licensed_id',
        'integration_data',
    ];

    public function company()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function licensed()
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }
}