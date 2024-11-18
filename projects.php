<?php
    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/registered.php");
    include("classes/collaborator.php");

    if (isset($_SESSION['collab_sessionid'])) {
        $no_projects = "";

        $check_project_input = false;
        $check_project_creation = false;

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
                        $_SESSION['check_project_input'] = $check_project_input;

                        header("Location: projects.php");
                        
                        return $check_project_input;

                    } else {
                        $project_image = "";
    
                        $project_check = new User();
                        $check_project_input = $project_check->project_evaluate($project_image, $_POST, $id);
                        $_SESSION['check_project_input'] = $check_project_input;

                        header("Location: projects.php");
    
                        return $check_project_input;
                    }

                } else if (isset($_POST['colaborador'])) {
                    $project_to_collaborate = $_POST['projeto_colaborador'];
                    $collaborator = $_POST['colaborador'];
                    $permission_type = $_POST['permissao'];

                    $collab_check = new Collab();

                    if ($collab_check->project_exists($_POST, $id)) {
                        $collaborator_added = "Adicionado com sucesso!";
                    }

                }

            }

            if( isset($_SESSION['check_project_input']) ) {
                $check_project_creation = $_SESSION['check_project_input'];
            }

            if ($check_project_creation) {

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
<html lang="pt-br">
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
        <h2>Meus projetos</h2>
        <div class="projects-wrapper hidden">
            <?php
            $this_project = false;
                if (!empty($projects)) {
                        echo "<button class='manage-projects'>Editar projetos</button>
                            <div class='global-carousel-wrapper'>
                                <div class='carousel-wrapper c-carousel c-carousel--simple'>";
                                for ($i = 0; $i < sizeof($projects); $i++) {
                                    $project_image = $projects[$i]['project_image'];
                                    $project_name = $projects[$i]['project_name'];
                                    $project_description = $projects[$i]['project_description'];
                                    $current_project = $projects[$i]['project_id'];
                                    $project_session = $projects[$i]['session_id'];

                                    if ($project_session  == $_SESSION['collab_sessionid']) {
                                        echo "<div class='carousel-item'>
                                            <a href='project-tasks.php?project_id=$current_project' class='card-link'>
                                                <img src='image-uploads/projects/$project_image' alt='Imagem 1'>
                                                <h2>$project_name</h2>
                                                <p>$project_description</p>
                                                <button class='material-symbols-outlined'>arrow_forward</button>
                                            </a>
                                        </div>";
                                    } else {
                                        echo "<div class='carousel-item' style='position: relative;'>
                                            <a href='project-tasks.php?project_id=$current_project' class='card-link'>
                                                <img src='image-uploads/projects/$project_image' alt='Imagem 1'>
                                                <h2>$project_name</h2>
                                                <p>$project_description</p>
                                                <button class='material-symbols-outlined'>arrow_forward</button>
                                            </a>
                                            <div class='project-collaborator'>
                                                <p> Colaborador </p>
                                            </div>
                                        </div>";
                                    }

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
        </div>
        <div id='tables-wrapper'>
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
                                $project_session = $projects[$i]['session_id'];
                    ?>
                                    <tr>
                                        <td><strong><?php echo $project_name; ?></strong></td>
                                        <td><?php echo $project_description; ?></td>
                                        <td>
                                        <?php
                                            $collab_check = new Collab();
                                            $participants = $collab_check->get_participants($project_id);
                                            // echo "<pre>";
                                            // print_r($participants);
                                            // echo "</pre>";
                                            if (is_array($participants) && count($participants) > 1) {
                                                echo "<div class='collaborator-info-wrapper hidden-btn'>
                                                <table class='collab-table'>
                                                    <tr>
                                                        <th>Colaboradores</th>
                                                    </tr>";
                                                foreach ($participants as $participant) {
                                                    $collab_username = htmlspecialchars($participant['username']);
                                                    $collab_session = $participant['session_id'];
                                                            echo "<tr>
                                                                <td><div class='collaborator-info'>$collab_username";
                                                                if ($collab_username != $_SESSION["project_owner" . $project_id]) {
                                                                    echo "<a href='classes/delete.php?collaborator_id=$collab_session&project_id=$project_id'><img src='imagens/remove.png' alt='Remover'></a>";
                                                                }
                                                                echo "</div></td>
                                                            </tr>";
            
                                                }
                                                            echo "</table>
                                                            <button class='manage-collaborators hidden' data-project-id='$project_id'>Adicionar</button>
                                                            <button class='close-collab-info'>Fechar</button>
                                                        </div>";
                                                if(count($participants) <= 5) {
                                                    foreach ($participants as $participant) {
                                                        $collab_username = htmlspecialchars($participant['username']);
                                                        $collab_session = $participant['session_id'];
                                                        echo htmlspecialchars($collab_username) . "<br>";
                                                    }
                                                } else {
                                                    for($i=0; $i<=5; $i++) {
                                                        echo htmlspecialchars($participants[$i]['username']) . "<br>";
                                                    }
                                                }
            
                                            } else {
                                                echo "Apenas você.";
                                            }?>
                                            <img src='imagens/dots.png' alt='editar colaboradores' class='edit-collab-all edit-collaborators'>
                                        </td>
                                        <?php
                                            $collab_check = new Collab();
                                            $permissions = $collab_check->check_permission($id, $project_id);
                                            if (!empty($permissions)) {
                                                if ($permissions[0]['permission_type'] === 'admin' || $project_session == $id) {
                                        ?>
                                        <td>
                                            <button class='edit-project edit-text' data-project-id='<?php echo $project_id; ?>'>Editar</button>
                                            <br>
                                            <button name='delete' class='delete-project delete-text'><a href='classes/delete.php?delete_id=<?php echo $project_id; ?>'>Excluir</a></button>
                                        </td>
                                        <?php } else {?>
                                            <td>
                                                <p>Sem permissões.</p>
                                            </td>
                                        <?php } } elseif ($project_session == $id) { ?>
                                        <td>
                                            <button class='edit-project edit-text' data-project-id='<?php echo $project_id; ?>'>Editar</button>
                                            <br>
                                            <button name='delete' class='delete-project delete-text'><a href='classes/delete.php?delete_id=<?php echo $project_id; ?>'>Excluir</a></button>
                                            <div class='actions-imgs'>
                                                <button class='edit-project edit-icon' data-project-id='<?php echo $project_id; ?>'><img class='edit-pencil' src="imagens/pencil.png" alt=""></button>
                                                <button class='delete-project delete-icon'><a href='classes/delete.php?delete_id=<?php echo $project_id; ?>'><img class='delete-trash' src="imagens/excluir_icone.png" alt=""></a></button>
                                            </div>
                                        </td>
                                        <?php } ?>
                                        <td><data value='<?php echo $project_date; ?>'><?php
                                            $dateObject = new DateTime($project_date);
                                            echo $dateObject->format('d/m/y');
                                        ?></data></td>
                                    </tr>
            
                    <?php
                               echo "<tr class='add-collaborators-row hidden-project-form'>
                               <td colspan='5'>
                                   <div id='add-collaborators' class='projects-forms'>
                                       <h2>Adicionar colaboradores</h2>
                                       <form action='' method='post'>
                                           <input type='hidden' name='projeto_colaborador' id='projeto_colaborador' value='{$project_id}'>
                                           <label for='permissao'>Permissão</label>
                                           <select name='permissao' id='permissao'>
                                               <option value='edit'>Edição</option>
                                               <option value='admin'>Administrador</option>
                                           </select>
                                           <label for='colaborador'>Colaborador</label>
                                           <input type='text' name='colaborador' id='colaborador' placeholder='Nome de usuário do colaborador' required>
                                           <div class='add-collab-btns'>
                                               <button class='cancel-add-collab' type='button'>Cancelar</button>
                                               <button class='add_participant' type='submit' name='submit'>Adicionar</button>
                                           </div>
                                       </form>
                                   </div>
                               </td>
                             </tr>";
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
        </div>
        
    </main>

    <?php include("partials/footer.php") ?>

    <script src="js/index.js"></script>
    
</body>
</html>

