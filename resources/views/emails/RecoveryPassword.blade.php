<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperação de Senha</title>
</head>
<body>
    <h3>Olá {{ $details['firstname'] }}, tudo bem? Esperamos que sim!</h3>
    <p>Abaixo estão as suas credenciais a partir da recuperação de senha que solicitou.</p>
    <p>Nome de usuário: {{ $details['username'] }}</p>
    <p>Senha: {{ $details['password'] }}</p>
    <p>Não se esqueça de mudar a senha quando entrar na plataforma, hein! ;)</p>
    <p>Atenciosamente,</p>
    <p>Equipe MyTCC.</p>
</body>
</html>