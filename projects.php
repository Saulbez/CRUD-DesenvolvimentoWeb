<?php

    session_start();


    include("classes/connect.php");
    include("classes/login.php");

    //check if user is logged in
    if (isset($_SESSION['collab_sessionid'])) {

        $id = $_SESSION['collab_sessionid'];
        $login = new Login();

        $result = $login->check_login($id);

        if($result) {



        } else {

            header("Location: login.php");
            die;

        }

    } else {
        
        header("Location: login.php");
        die;

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/projects.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>
<body>
    
    <?php
        include 'header.php';
    ?>


    <form action="" method="post" >
        <label for="project_name">Projeto</label>
        <input type="text" id="project_name" name="project_name" placeholder="Digite o nome do projeto" required>
        <input type="submit" value="Criar">
    </form>



    <div class="global-carousel-wrapper">
        <div class="carousel-wrapper c-carousel c-carousel--simple">
            <div class="carousel-item c-carousel__slide">
                <a href="#" class="card-link">
                    <img src="imagens/placeholder.jpg" alt="Imagem 1">
                    <h2>Lorem ipsum dolor sit amet</h2>
                    <button class="material-symbols-outlined">arrow_forward</button>
                </a>
            </div>
            <div class="carousel-item c-carousel__slide">
                <a href="#" class="card-link">
                    <img src="imagens/placeholder2.jpg" alt="Imagem 2">
                    <h2>Lorem ipsum dolor sit amet</h2>
                    <button class="material-symbols-outlined">arrow_forward</button>
                </a>
            </div>
            <div class="carousel-item c-carousel__slide">
                <a href="#" class="card-link">
                    <img src="imagens/placeholder.jpg" alt="Imagem 3">
                    <h2>Lorem ipsum dolor sit amet</h2>
                    <button class="material-symbols-outlined">arrow_forward</button>
                </a>
            </div>
            <div class="carousel-item c-carousel__slide">
                <a href="#" class="card-link">
                    <img src="imagens/placeholder2.jpg" alt="Imagem 2">
                    <h2>Lorem ipsum dolor sit amet</h2>
                    <button class="material-symbols-outlined">arrow_forward</button>
                </a>
            </div>
            <div class="carousel-item c-carousel__slide">
                <a href="#" class="card-link">
                    <img src="imagens/placeholder.jpg" alt="Imagem 3">
                    <h2>Lorem ipsum dolor sit amet</h2>
                    <button class="material-symbols-outlined">arrow_forward</button>
                </a>
            </div>
            <button class="material-symbols-outlined prev"> arrow_forward_ios </button>
            <button class="material-symbols-outlined next"> arrow_forward_ios </button>
            <div class="js-carousel--simple-dots"></div>
        </div>
    </div>

    <table class="hidden">
        <tr>
            <th>Projeto</th>
            <th>Descrição</th>
            <th>Equipe</th>
            <th>Ações</th>
            <th>Data de criação</th>
        </tr>
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    
</body>
</html>

