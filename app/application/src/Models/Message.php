<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\AccessControl\Models\User;

class Message extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Usuário que enviou a mensagem
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Usuário que recebeu a mensagem
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
