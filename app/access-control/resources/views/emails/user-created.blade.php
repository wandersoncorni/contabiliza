<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Novo Usuário Criado</title>
</head>
<body>
    <h2>Olá, Administrador!</h2>
    <p>Um novo usuário foi criado no sistema:</p>
    <ul>
        <li><strong>Nome:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
    </ul>
    <p>Atenciosamente, <br> Equipe do Contabiliza</p>
</body>
</html>
