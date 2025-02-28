<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Associado extends Model
{
    use HasFactory;

    protected $table = 'associados';

    protected $fillable = ['client_id', 'associated_id'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'client_id');
    }

    public function associated(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'associated_id');
    }
}
