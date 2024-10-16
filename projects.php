<?php
    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/registered.php");

    //check if user is logged in
    if (isset($_SESSION['collab_sessionid'])) {
        $no_projects = "";

        $check_project_input = false;

        $id = $_SESSION['collab_sessionid'];
        $login = new Login();

        $result = $login->check_login($id);

        if($result) {

            if (isset($_POST['submit'])) {

                if(isset($_FILES['project-image'])) {
                    if($_FILES['project-image']['error'] != 4) {
                        $project_image = $_FILES['project-image'];

                        $project_check = new User();
                        $check_project_input = $project_check->project_evaluate($project_image, $_POST, $id);

                        header("Location: projects.php");
                        
                        return $check_project_input;

                    } else {
                        $project_image = "";
    
                        $project_check = new User();
                        $check_project_input = $project_check->project_evaluate($project_image, $_POST, $id);

                        header("Location: projects.php");
    
                        return $check_project_input;
                    }

                }

            }

            if ($check_project_input) {

            }

            $user = new User();
            $projects = $user->get_projects($id);
            // echo '<pre>';
            // print_r($projects);
            // echo '</pre>';

            if (!$projects) {
                $no_projects .= "Você ainda não criou nenhum projeto.";
            }

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
    <link rel="stylesheet" href="styles/footer.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>
<body>
    <header>
        <?php
            include 'partials/header.php';
        ?>
    </header>

    <main>
        <div class="create-project-form">
            <div class="input-project-name projects-forms">
                <h2>Crie um novo projeto</h2>
                <form class="hidden-project-form project-form" action="" method="post" enctype="multipart/form-data">
                    <label for="project-name">Nome do projeto</label>
                    <input type="text" name="project-name" id="project-name" placeholder="Digite o nome do projeto" required>
                    <label for="project-description">Descrição do projeto</label>
                    <input type="text" id="project-description" name="project-description" placeholder="Descrição do projeto">
                    <label for="project-image">Imagem do projeto</label>
                    <input type="file" name="project-image" id="project-image" accept="image/png, image/jpeg, image/jpg">
                    <button type="submit" name="submit" class="create-project">Criar</button>
                </form>
                <button class="create-project-dropdown">Criar</button>
            </div>
        </div>
        <h2 class="hidden">Meus projetos</h2>
        <?php
        $this_project = false;
            if (!$no_projects) {
                    echo "<button class='manage-projects hidden'>Editar projetos</button>
                        <div class='global-carousel-wrapper hidden'>
                            <div class='carousel-wrapper c-carousel c-carousel--simple'>";
                            for ($i = 0; $i < sizeof($projects); $i++) {
                                $project_image = $projects[$i]['project_image'];
                                $project_name = $projects[$i]['project_name'];
                                $project_description = $projects[$i]['project_description'];
                                $current_project = $projects[$i]['project_id'];

                                $this_project = $i;
                            
                                echo "<div class='carousel-item'>
                                    <a href='project-tasks.php?project_id=$current_project' class='card-link'>
                                        <img src='uploads/$project_image' alt='Imagem 1'>
                                        <h2>$project_name</h2>
                                        <p>$project_description</p>
                                        <button class='material-symbols-outlined'>arrow_forward</button>
                                    </a>
                                </div>";
                            }
                                echo"<button class='material-symbols-outlined prev'> arrow_forward_ios </button>
                                <button class='material-symbols-outlined next'> arrow_forward_ios </button>
                                <div class='js-carousel--simple-dots'></div>
                            </div>
                        </div>";

            } else {
                echo '<p style="margin-bottom: 7rem;">'.$no_projects.'</p>';
            }

        ?>
        <div class="table-wrapper">
            <table class="hide-projects-table projects-table hidden">
                <tr>
                    <th>Projeto</th>
                    <th>Descrição</th>
                    <th>Participantes</th>
                    <th>Ações</th>
                    <th>Data de criação</th>
                </tr>
                <?php
                    if (!$no_projects) {
                        for ($i = 0; $i < sizeof($projects); $i++) {
                            $project_name = $projects[$i]['project_name'];
                            $project_description = $projects[$i]['project_description'];
                            $project_date = $projects[$i]['data_criacao'];
                            $project_id = $projects[$i]['project_id'];
                ?>
                            <tr>
                                <td><strong><?php echo $project_name; ?></strong></td>
                                <td><?php echo $project_description; ?></td>
                                <td><p>Marcos</p> <p>Erika</p></td>
                                <td>
                                    <button class='edit-project' data-project-id='<?php echo $project_id; ?>'>Editar</button>
                                    <br>
                                    <button name='delete' class='delete-project'><a href='classes/delete.php?delete_id=<?php echo $project_id; ?>'>Excluir</a></button>
                                </td>
                                <td><data value='<?php echo $project_date; ?>'><?php echo $project_date; ?></data></td>
                            </tr>
                <?php
                        }
                    }
                ?>
            </table>
            <div class="edit-project-form hidden-project-form projects-forms">
                <h2>Editar projeto</h2>
                <form class="project-form update-project-form" action="" method="post" enctype="multipart/form-data">
                    <label for="project-name">Nome do projeto</label>
                    <input type="text" name="project-name" id="project-name" placeholder="Digite o nome do projeto">
                    <label for="project-description">Descrição do projeto</label>
                    <input type="text" id="project-description" name="project-description" placeholder="Descrição do projeto">
                    <label for="project-image">Imagem do projeto</label>
                    <input type="file" name="project-image" id="project-image" accept="image/png, image/jpeg, image/jpg">
                    <input type="hidden" name="update_id" value="">
                    <div class="edit-cancel">
                        <button type="button" class="cancel">Cancelar</button>
                        <button type='submit' name='submit' class='edit-project-confirm'>Editar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- <div id="add_collaborators" class="projects-forms">
            <h2>Adicionar colaboradores</h2>
            <form action="" method="post">
                <label for="projeto_colaborador">Projeto</label>
                <select name="projeto_colaborador" id="projeto_colaborador">
                    <?php //for($i = 0; $i < sizeof($projects); $i++) {
                        //$project_name = $projects[$i]['project_name'];
                        //echo "<option value='$project_name'>$project_name</option>";
                    //}?>
                </select>
                
                <label for="permission_type">Permissão</label>
                <select name="permission_type" id="permission_type">
                    <option value="edit">Edição</option>
                    <option value="admin">Administrador</option>
                </select>

                <label for="colaborador">Colaborador</label>
                <input type="text" name="colaborador" id="colaborador" placeholder="Colaborador" required>
                <button type="submit" name="add_participant">Adicionar</button>
            </form>
        </div> -->
    </main>

    <?php include("partials/footer.php") ?>

    <script src="js/index.js"></script>
    
</body>
</html>

