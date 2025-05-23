<?php

namespace App\Logger\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'message',
        'context',
        'level',
        'created_at',
    ];
}
