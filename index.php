<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>

    <link rel="stylesheet" href="styles/header.css" type="text/css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/index.css" type="text/css">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

</head>
<body>
    <?php
        include 'partials/header.php';
    ?>

    <div class="hero">
        <div class="hero-left">
            <h2>Crie e planeje projetos em conjunto!</h2>
            <p>Esse site foi pensado para você criar, planejar e organizar seus projetos, trabalhar em equipe e elevar o nível das suas ideias, trazendo inovações e pensando em conjunto para trazer seus pensamentos a vida.</p>
        </div>
        <div class="hero-right">
            <img src="imagens/Projects.png" alt="Imagem ilustrativa de diversos projetos." class="hero-image">
        </div>
    </div>

    <div class="features">
        <div class="feature-images">
            <div class="feature-img">
                <div class="feature-img-wrapper">
                    <img src="imagens/colaboração.png" alt="Ilustração de pessoas colaborando">
                </div>
                <h2> Colaboração</h2>
                <p>Trabalhe em conjunto utilizando nossa plataforma</p>
            </div>
            <div class="feature-img">
                <div class="feature-img-wrapper">
                    <img src="imagens/planejamento.png" alt="Ilustração de um planejamento">
                </div>
                <h2>Planejamento</h2>
                <p>Crie objetivos e metas para seu projeto</p>
            </div>
            <div class="feature-img">
                <div class="feature-img-wrapper">
                    <img src="imagens/gerenciamento-de-projetos.png" alt="Ilustração de gerenciamento de projetos">
                </div>
                <h2>Gerenciamento</h2>
                <p>Defina colaboradores para tarefas específicas</p>
            </div>
            <div class="feature-img">
                <div class="feature-img-wrapper">
                    <img src="imagens/segurança.png" alt="ilustração de um perfil de usuário com criptografia">
                </div>
                <h2>Segurança</h2>
                <p>Segurança e privacidade para os seus projetos</p>
            </div>
        </div>
        <div class="call-to-action">
            <h2>A maneira mais segura e eficaz de planejar suas atividades.</h2>
            <p> Cadastre-se já e comece imdediatamente a conquistar seus objetivos com a ajuda de nossa plataforma! </p>
            <a href="/CRUD-DesenvolvimentoWeb/projects.php">Começar</a>
        </div>
    </div>

    <?php include('partials/footer.php') ?>

    <script src="js/index.js"></script>
</body>
</html>