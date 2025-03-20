<h1>Olá {{ $user->name }},</h1>
<p>Obrigado por se cadastrar em nossa plataforma! Para finalizar o seu cadastro, clique no link abaixo para confirmar o seu e-mail:</p>
<a href="{{ route('email-validate', ['id'=>$user->id, 'token' => sha1($user->email)]) }}">Confirmar meu e-mail</a>
<p>Se você não se cadastrou, ignore este e-mail.</p>
