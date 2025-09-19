<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaCnae extends Model
{
    protected $table = 'empresa_cnae';

    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'cnae_id',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}