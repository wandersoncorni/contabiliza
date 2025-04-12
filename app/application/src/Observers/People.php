<?php

namespace App\Application\Observers;

use App\Application\Models\People as PeopleModel;

class People
{
    public function deleting(PeopleModel $people)
    {
        $client = $people->client;

        // Exclui o cliente se essa for a última pessoa
        if ($client && $client->people()->count() === 1) {
            $client->delete();
        }
    }
}
