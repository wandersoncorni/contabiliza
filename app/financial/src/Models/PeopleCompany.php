<?php

namespace App\Financial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeopleCompany extends Model
{
    use HasFactory;

    protected $table = 'people_company';

    public $timestamps = true;

    protected $fillable = [
        'licensed_id',
        'company_id',
        'name',
        'tax_id',
        'type',
        'email',
        'phone',
        'zipcode',
        'address',
        'complement',
        'district',
        'number',
        'phone1',
        'phone2',
        'city',
        'state_registration',
        'trade_name',
    ];

    protected $hidden = [
        'licensed_id',
        'company_id',
    ];

    public function licensed(): BelongsTo
    {
        return $this->belongsTo(Licensed::class, 'licensed_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'company_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'person_id');
    }
}