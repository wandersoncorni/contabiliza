<h1>Prezado {{ $user->name }},</h1>
<p>Esta mensagem é para confirmar a edição do e-mail em sua conta. Ela permanecerá inativa até que você confirme este novo endereço. 
Por favor, acesse o endereço abaixo para desbloquear sua conta.</p>
<a href="{{ route('email.validate', ['id'=>$user->id, 'token' => sha1($user->email)]) }}">Confirmar meu e-mail</a>
<p>Caso não tenha sido você e sua conta estiver inativa informe o administrador.</p>
