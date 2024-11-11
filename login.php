<?php

    session_start();

    include("classes/connect.php");
    include ("classes/signup.php");
    include("classes/login.php");

    $username = "";
    $email = "";
    $password = "";

    $result_signup = "";
    $result_login = "";


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
                        <label for="check" aria-hidden="true" class="signup-label">Cadastre-se</label>
                        <label for="username-signup" class="label-inputs">Nome de usuário</label>
                        <input value="<?php echo $username?>" type="text" name="username" id="username-signup" placeholder="Nome de usuário" required>
                        <label for="email-signup" class="label-inputs">Email</label>
                        <input value="<?php echo $email ?>" type="email" name="email" id="email-signup" placeholder="Email" required>
                        <label for="password-signup" class="label-inputs">Senha</label>
                        <input type="password" name="password" id="password-signup" placeholder="Senha" required>

                        <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'signup') {
                                $signup = new Signup();
                                
                                try {
                                    $result_signup = $signup->evaluate($_POST);
                                    
                                    // If the result is true, the signup was successful
                                    if ($result_signup === true) {
                                        echo "<p style='color: darkgreen; margin: 4px 0;'>Cadastro realizado com sucesso!</p>";
                                        echo "<script>setTimeout(function(){ window.location.href='login.php'; }, 2000);</script>";
                                    } else {
                                        // Handle other types of responses
                                        echo "<p style='margin: 4px 0;'>Houve um erro durante o cadastro.</p>";
                                    }
                                } catch (Exception $e) {
                                    // Check if the exception message contains the specific error
                                    if (strpos($e->getMessage(), "Duplicate entry " . "'" . $_POST['email'] . "'" . " for key 'email'") !== false) {
                                        echo "<p style='color: red; margin: 4px 0;'>Esse email já está cadastrado.</p>";
                                    } else {
                                        // Handle other exceptions
                                        echo "<p style='color: red; margin: 4px 0;'>Erro: " . $e->getMessage() . "</p>";
                                    }
                                }

                                $username = $_POST['username'];
                                $email = $_POST['email'];
                            }
                        ?>

                        <input type="hidden" name="action" value="signup">

                        <input name="signup" type="submit" value="Cadastre-se"></input>
                    </form>
                </div>

                <div class="login">
                    <form method="post">
                        <label for="check" aria-hidden="true">Entrar</label>
                        <label for="email-login" class="label-inputs">Email</label>
                        <input value="<?php echo $email ?>" type="email" name="email" id="email-login" placeholder="Email" required>
                        <label for="password-login" class="label-inputs">Senha</label>
                        <input value="<?php echo $password ?>" type="password" name="password" id="password-login" placeholder="Senha" required>
                        
                        <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'login') {
                                $login = new Login();
                                $result_login = $login->evaluate($_POST);
                                if ($result_login === true) {
                                    header("Location: projects.php");
                                    die;
                                } else {
                                    echo "<p>$result_login</p>";
                                }

                                $email = $_POST['email'];
                                $password = $_POST['password'];
                            }
                        ?>

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