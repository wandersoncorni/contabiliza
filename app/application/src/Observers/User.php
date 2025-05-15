<?php

namespace App\Application\Observers;

use App\AccessControl\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class User
{
    public function deleting()
    {
        $user = UserModel::where('id', request()->input('id'))->with('person')->first();
        if (in_array('client', $user->person->roles)) {
            DB::table('people_clients')->where('client_id', $user->person->id)->delete();
            $user->person->delete();
        }
        elseif (in_array('agent', $user->person->roles)) {
            DB::table('people_clients')->where('person_id', $user->person->id)->delete();
            $user->person->delete();
        }
    }
}
