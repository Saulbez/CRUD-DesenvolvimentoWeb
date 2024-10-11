<?php

    session_start();

    include("classes/connect.php");
    include ("classes/signup.php");
    include("classes/login.php");

    $username = "";
    $email = "";
    $password = "";


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['action'] == 'signup') {
            $signup = new signup();
            $result = $signup->evaluate($_POST);

            if ($result != "") {
                echo '<div style="text-align: center; background-color: #161D6F; color: #F6F6F6; font-size: 1rem; margin: 0; padding: 20px;">';
                echo $result;
                echo '</div>';
            } else {

                header("Location: login.php");
                die;

            }

            $username = $_POST['username'];
            $email = $_POST['email'];

        } elseif ($_POST['action'] == 'login') {

            $login = new Login();
            $result = $login->evaluate($_POST);

            if ($result != "") {

                echo '<div style="text-align: center; background-color: #161D6F; color: #F6F6F6; font-size: 1rem; margin: 0; padding: 20px;">';
                echo $result;
                echo '</div>';

            } else {

                header("Location: projects.php");
                die;

            }

            $email = $_POST['email'];
            $password = $_POST['password'];


        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    
    <?php
        include 'partials/header.php';
    ?>
    <div class="flex-wrapper">
        <div id="first-section">
            <h1>Crie sua conta agora e retome o controle</h1>
            <img src="imagens/undraw_engineering_team_a7n2.svg" alt="">
        </div>
        <div id="second-section">
            <div id="form-div">
                <input type="checkbox" name="check" id="check" aria-hidden="true">

                <div class="signup">
                    <form method="post">
                        <label for="check" aria-hidden="true">Cadastre-se</label>
                        <input value="<?php echo $username?>" type="text" name="username" id="username" placeholder="Nome de usuário" required>
                        <input value="<?php echo $email ?>" type="email" name="email" id="email" placeholder="Email" required>
                        <input type="password" name="password" id="password" placeholder="Senha" required>

                        <input type="hidden" name="action" value="signup">

                        <input name="signup" type="submit" value="Cadastre-se"></input>
                    </form>
                </div>

                <div class="login">
                    <form method="post">
                        <label for="check" aria-hidden="true">Entrar</label>
                        <input value="<?php echo $email ?>" type="email" name="email" id="email" placeholder="Email" required>
                        <input value="<?php echo $password ?>" type="password" name="password" id="password" placeholder="Senha" required>
                        
                        <input type="hidden" name="action" value="login">

                        <input name="login" type="submit" value="Entrar"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/index.js"></script>
</body>
</html>