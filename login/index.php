<?php
    if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        header("Location: ./checker/loginChecker.php");
    }

    session_start();

    if (isset($_SESSION['isLog'])) {
        header("Location: ../calendar/index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Login </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/evea-icon-fundo-preto.png" >
</head>
<body>
    <noscript>
        <div class="noscript">
            <h2>O javascript do seu navegador está desativado, isto pode causar erros e fazer com que a aplicação deixe de funcionar.</h2>
            <h4>Para ativar o javascript abra as configurações> avançado> Configurações do site> Javascript e ative esta opção!</h4>
        </div>
    </noscript>
    <div class="container">
        <form class="form-group">
            <div class="header">
                <h2>LOGIN</h2>
            </div>
            <div class="input-group">
                <!-- <label for="">E-mail</label> -->
                <input type="email" name="" id="input-email" autofocus placeholder="Digite seu e-mail">
            </div>
            <div class="email-error error">
                <p>* Por favor, digite um e-mail válido</p>
            </div>
            <div class="input-group">
                <!-- <label for="">Senha</label> -->
                <input type="password" name="" id="input-password" placeholder="Digite sua senha">
            </div>
            <div class="password-error error">
                <p>* Por favor, digite uma senha válida</p>
            </div>
            <div class="options-group">
                <div class="option">
                    <input type="checkbox" name="" id="inputRememberMe">
                    <label for="inputRememberMe"></label>
                    <label for="inputRememberMe" class="optLabel">Mantenha-me Conectado</label>
                </div>
            </div>
            <div class="login-error error">
                <p>* E-mail ou senha incorretos</p>
            </div>
            <div class="btn-submit">
                <input type="submit" value="Login">
            </div>
            <div class="options-group">
                <div class="option">
                    <p>Esqueçeu sua senha?</p>
                    <a href="recover/index.php">Clique aqui</a>
                </div>
            </div>
            <!-- <div class="guest">
                <input type="button" value="Entrar como convidado">
            </div> -->
        </form>
    </div>
    <div class="spinPos">
        <div class="spinner"></div>
        <div class="spinTxt">Carregando</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>
</html>