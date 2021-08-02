<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Teste</title>
</head>
<body>
    <h3>Seja bem-vindo à sua nova plataforma de gerenciamento de TCC's!</h3>
    <p>Ficamos muito felizes por ter nos escolhido, {{ $details['firstname'] }}.</p>
    <p>Para começar a desfrutar das facilidades que o MyTCC te proporciona, abaixo estão suas credenciais para login:</p>
    <p>Nome de usuário: {{ $details['username'] }}</p>
    <p>Senha: {{ $details['password'] }}</p>
    <p>Não se esqueça de mudar a senha quando entrar na plataforma, hein! ;)</p>
    <p>Atenciosamente,</p>
    <p>Equipe MyTCC.</p>
</body>
</html>