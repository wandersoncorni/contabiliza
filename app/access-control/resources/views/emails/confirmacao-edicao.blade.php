<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de edição</title>
</head>
<body>
    <h2>Olá, {{ $user->name }}!</h2>
    <p>Seu email doi editado no sistema e solicitamos que confirme a nova informação clicando no link abaixo:</p>
    <a href="{{ url('/') }}/email/verify/{{ $user->id }}/{{ sha1($user->email) }}">Clique aqui para confirmar</a>
    <p>Se você não solicitou essa alteração, por favor, entre em contato conosco.</p>
    <p>Atenciosamente, <br> Equipe do Contabiliza</p>
</body>
</html>