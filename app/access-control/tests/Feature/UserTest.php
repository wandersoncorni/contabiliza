<?php

use App\AccessControl\Models\User;
use App\AccessControl\Mail\UserCreatedAdminNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;

it('criar o usuário cliente', function () {
    $userData = [
        'email' => 'cliente@contabiliza.com.br',
        'name' => 'cliente',
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
    ];

    Mail::fake();
    Notification::fake();
    $response = $this->postJson('/api/v1/register', $userData);
    if (!$response->assertStatus(201)) {
        return;
    }
    $user = User::where('email', $userData['email'])->first();
    Notification::assertSentTo($user, VerifyEmail::class);
    $response->assertStatus(201);
    $adminMail = config('mail.admin_email');
    Mail::assertSent(UserCreatedAdminNotification::class, function ($mail) use ($adminMail) {
        return in_array($adminMail, array_column($mail->to, 'address'));
    });
    $this->assertDatabaseHas('users', [
        'email' => $userData['email'],
    ]);
});

it('criar um usuario com perfil diferente de cliente com permissão para tal', function () {
    $userData = [
        'email' => 'admin@contabiliza.com.br',
        'name' => 'admin',
        'roles' => 'admin'
    ];
    // Loga o usuario
    $admin = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->get()->first();

    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Password@123',
    ]);

    $response = $this->postJson('/api/v1/register', $userData);

    $response->assertStatus(201);
    $this->assertDatabaseHas('users', [
        'email' => $userData['email'],
    ]);
});

it('negar criar um usuario com perfil diferente de cliente sem permissão para tal', function () {
    $userData = [
        'email' => 'manager@contabiliza.com.br',
        'name' => 'consultant',
        'roles' => 'manager'
    ];
    // Loga o usuario
    $consultant = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();
    $consultant->email_verified_at = now();
    $consultant->active = 1;
    $consultant->save();

    $this->postJson('/api/v1/login', [
        'email' => $consultant->email,
        'password' => 'Password@123',
    ]);

    $response = $this->postJson('/api/v1/register', $userData);
    $response->assertStatus(403);
});

/**
 * Testa a autenticacao do usuario por outro com permissao de criar usuarios
 * O deverah ser autenticado e a nova contra criada receberah o perfil 
 * de que ele atribuir, menos o de cliente
 */
it('reenvia o email de validação', function () {
    $consultant = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();
    $consultant->email_verified_at = now();
    $consultant->active = 1;
    $consultant->save();

    $resp = $this->postJson('/api/v1/login', [
        'email' => $consultant->email,
        'password' => 'Password@123',
    ]);

    Notification::fake();
    $user = User::where('email', 'cliente@contabiliza.com.br')->first();
    $response = $this->postJson('/api/v1/email/resend', [
        'id' => $user->id,
        'email' => $user->email
    ]);

    if (!$user->hasVerifiedEmail()) {
        Notification::assertSentTo($user, VerifyEmail::class);
        $response->assertStatus(200);
    } else {
        $response->assertStatus(400)->assertJson(['error' => 'O e-mail ja foi validado!']);
    }
});

it('valida o email do usuario', function () {
    $user = User::where('email', 'cliente@contabiliza.com.br')->first();

    $mailHash = sha1($user->email);
    $response = $this->getJson("/api/v1/email/verify/$user->id/$mailHash");
    $response->assertStatus(302);
});

it('trocar a senha do usuario', function () {
    // loga na aplicacao
    $user = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();
    $user->email_verified_at = now();
    $user->active = 1;
    $user->save();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);
    
    $response->assertStatus(200);

    $updateData = [
        'current_password' => 'Password@123',
        'password' => 'Novasenha@123',
        'password_confirmation'=> 'Novasenha@123'
    ];

    // Realiza a requisição PUT para atualizar os dados
    $response = $this->putJson('/api/v1/user', $updateData);

    // Verifica se a resposta tem status 200 (sucesso na atualização)
    $response->assertStatus(200);

    $response = $this->get('/api/v1/logout');
    $response->assertStatus(302);

    // Verifica se a senha foi realmente alterada
    $user->refresh();    
    $this->assertTrue(Hash::check('Novasenha@123', $user->password));
});

it('mudar o estado de ativo/inativo e perfil', function(){
    $admin = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->get()->first();
    
    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Password@123',
    ]);

    $user = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    // Inativa o usuario
    $response = $this->patchJson('/api/v1/user', ['id'=>$user->id,'active'=>0]);
    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'active' => 0
    ]);
});

// it('excluir um usuário como admin', function(){
//     $admin = User::whereHas('people',function($query){
//         $query->where('roles', 'LIKE', '%admin%');
//     })->get()->first();
//     $admin->email_verified_at = now();
//     $admin->active = 1;
//     $admin->save();

//     $user = User::whereHas('people',function($query){
//         $query->where('roles', 'LIKE', '%client%');
//     })->get()->first();
    
//     $this->postJson('/api/v1/login', [
//         'email' => $admin->email,
//         'password' => 'Password@123',
//     ]);
    
//     $response = $this->delete('api/v1/user',['id'=>$user->id]);
//     $response->assertStatus(200);
// });

// it('logar a acao da exclusão por terceiro', function(){
//     $logMessage = DB::table('logs')
//     ->orderBy('id','desc')
//     ->first();
//     expect($logMessage->context)->toMatch('/exclusao por terceiro/');
// });

// it('excluir o próprio usuário', function(){
//     $user = User::first();
//     $pid = Profile::where(['label'=>'researcher'])->get()->pluck('id')[0];
//     $user->update(['profile_id'=>$pid,'active'=>1]);
//     $this->postJson('/api/v1/login', [
//         'email' => $user->email,
//         'password' => 'Password@123',
//     ]);
    
//     $response = $this->delete('api/v1/user',['id'=>$user->id]);
//     $response->assertStatus(302);
// });

// it('logar a acao de autoexclusão', function(){
//     $logMessage = DB::table('logs')
//     ->orderBy('id','desc')
//     ->first();
//     expect($logMessage->context)->toMatch('/autoexclusao/');
// });

// it('não pode excluir um usuário', function(){
//     $user = User::whereHas('people', function ($query) {
//         $query->where('roles', 'NOT LIKE', '%admin%');
//     })->get()->first();
//     $user->email_verified_at = now();
//     $user->active = 1;
//     $user->save();
//     $response = $this->postJson('/api/v1/login', [
//         'email' => $user->email,
//         'password' => 'Password@123',
//     ]);

//     if(!Auth::user()){
//         dd($response->json()['error']);
//     }

//     $response = $this->delete('api/v1/user',['id'=>4]);
//     $response->assertStatus(403);
// });
