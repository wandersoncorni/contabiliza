<?php

namespace App\Application\Database\Seeders;

use App\Application\Models\Message;
use App\AccessControl\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id')->toArray();

        if (count($users) < 2) {
            // Precisamos de pelo menos 2 usuários para enviar mensagens
            return;
        }

        // Gerar 50 mensagens aleatórias
        for ($i = 0; $i < 50; $i++) {
            $senderId = $users[array_rand($users)];
            $receiverId = $users[array_rand($users)];

            // Evitar que o usuário envie mensagem para ele mesmo
            while ($senderId === $receiverId) {
                $receiverId = $users[array_rand($users)];
            }

            Message::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'content' => fake()->sentence(12),
                'read_at' => rand(0, 1) ? now() : null, // aleatoriamente lido ou não
            ]);
        }
    }
}
