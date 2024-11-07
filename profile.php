<?php
session_start();

include("classes/connect.php");
include("classes/login.php");

if (isset($_SESSION['collab_sessionid'])) {

    $id = $_SESSION['collab_sessionid'];
    $login = new Login();

    $result = $login->check_login($id);

    if($result) {

        $query = "select id_users, username, email, profile_image from users where session_id = ?";
        $types = "s";
        $params = [$id];

        $DB = new Database();
        $userData = $DB->read($query, $types, ...$params);

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        if (isset($_SESSION['imageErrorMessage'])){
            echo $_SESSION['imageErrorMessage'];

        }
        
        $showNewPasswordForm = isset($_SESSION['showNewPasswordForm']) ? $_SESSION['showNewPasswordForm'] : false;
        unset($_SESSION['showNewPasswordForm']);
        
        $passwordVerified = isset($_SESSION['passwordVerified']) ? $_SESSION['passwordVerified'] : false;
        unset($_SESSION['passwordVerified']);

    }

} else {
    header("Location: login.php");
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/profile.css">

</head>
<body>
    <header>
        <?php include ("partials/header.php") ?>
    </header>

    <main>
        <div id="account-info">
            <h2>Minhas informações</h2>
            <hr>
            <div class="profile-image-wrapper"><img class="profile-image" src="image-uploads/profile/<?php echo $userData[0]['profile_image']; ?>" alt=""></div>
            <form id="profileImageForm" action="http://localhost/CRUD-DesenvolvimentoWeb/controllers/profile_handler.php" method="post" enctype="multipart/form-data">
                <input type="file" name="profile-image" id="profile-image" accept="image/*" style="display: none;" onchange="this.form.submit();">
                <button name="updateProfileImage" class="edit-profile-image" type="button" onclick="document.getElementById('profile-image').click();">Atualizar foto de perfil</button>
            </form>
            <div class="username-options">
                <h2 class="username"><?php echo $userData[0]['username']; ?></h2>
                <button class="edit-username"><img src="imagens/pencil.png" alt=""></button>

                <div id="username-form" class="hidden">
                    <hr>
                    <form action="/CRUD-DesenvolvimentoWeb/controllers/profile_handler.php" method="post">
                        <label for="new-username">Novo nome de usuário:</label>
                        <input type="text" name="new-username" id="new-username" placeholder="Nome de usuário">
                        <input type="submit" name="update-username" value="Mudar">
                    </form>
                </div>
                
            </div>
            <button class="change-password">Mudar senha</button>

            <div id="password-form" class="hidden">
                <h3>Mudar senha</h3>
                <form action="/CRUD-DesenvolvimentoWeb/controllers/profile_handler.php" method="post">
                <?php if (isset($showNewPasswordForm) && !$showNewPasswordForm){ ?>
                <label for="current_password">Senha atual:</label>
                <input type="password" name="current_password" id="current_password" required>

                <p><?php if (isset($message)) echo $message; ?></p>

                <?php if ( (isset($message) && $message != 'Senha atualizada!') || !(isset($message))) {
                    echo "<input type='submit' name='verify_password' value='Enviar'>
                    <button type='button' class='cancel'>Cancelar</button>";
                } else {
                    echo "<button type='button' class='close' name='close'>Fechar</button>";
                } ?>

                <?php } ?>

                <?php if (isset($showNewPasswordForm) && $showNewPasswordForm): ?>
                    <p><?php if (isset($message)) echo $message; ?></p>
                    <label for="new_password">Nova senha:</label>
                    <input type="password" name="new_password" id="new_password" required>

                    <input type='submit' name='change_password' value='Mudar senha'>
                    <button type='button' class='cancel'>Cancelar</button>

                <?php endif; ?>
                
                </form>
            </div>
            <form action="/CRUD-DesenvolvimentoWeb/controllers/profile_handler.php" method="post">
                <button type="submit" name="logoff" class="logoff">Sair</button>
            </form>
        </div>
    </main>

    <footer>
        <?php include ("partials/footer.php") ?>
    </footer>

    <script src="js/profile.js"></script>
    <script>

        <?php if ($passwordVerified or ((isset($message)) && $message == 'Senha atualizada!')): ?>

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('button.change-password').click();
            });
        <?php endif; ?>
        
    </script>
</body>
</html>