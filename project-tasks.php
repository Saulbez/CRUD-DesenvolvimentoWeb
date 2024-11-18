<?php
session_start();

include("classes/connect.php");
include("classes/login.php");

if(!isset($_SESSION['collab_sessionid'])) {
    header("Location: login.php");
} else {
    $sessionid = $_SESSION['collab_sessionid'];
    $login = new Login();
    $result = $login->check_login($sessionid);

    if(!$result) {
        header("Location: login.php");
    }
}

$projeto = $_GET['project_id'];

$_SESSION['project_id'] = $projeto;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto</title>

    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/project-tasks.css">
    <link rel="stylesheet" href="styles/button.css">
    <link rel="stylesheet" href="styles/footer.css">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    
</head>

<body>
    <?php include('partials/header.php') ?>

    <main>
        <h2>Gerenciar tarefas</h2>
        <button class="new-step add_step_button general">Nova etapa</button>
        <div class="form-wrapper hidden">
            <form action="controllers/project-tasks-handler.php" method="post">
                <label for="add_step">Nova etapa</label>
                <input type="text" id="add_step" name="add_step" placeholder='Nome da etapa'>
                <button type="submit" name="submit" class="add_step_button">Adicionar</button>
            </form>
        </div>
        <?php

        $query = "select * from steps where project_id = ?";
        $types = "i";
        $params = [$projeto];

        $DB = new Database();
        $DB->connect();
        $result = $DB->read($query, $types, ...$params);

        if (is_array($result) && sizeof($result) > 0) {
            echo "<div id='tables-wrapper'>";

            foreach ($result as $step) {
                $step_id = $step['step_id'];
                $step_title = $step['step_title'];

                echo "<div class='table-wrapper'>
                    <table class='task-container' data-step-id='$step_id'>
                        <tr>
                            <th>$step_title
                                <div id='task-creation'>
                                    <div class='step-actions'>
                                        <button class='edit-step'><img src='imagens/pencil.png'></button>
                                        <button class='delete-step-first'><img src='imagens/excluir_icone.png'></button>

                                        <div class='delete-step-confirmation hidden'>
                                            <p>Deseja realmente excluir esta <strong>etapa</strong>?</p>

                                            <button class='cancel-delete-step'>Cancelar</button>
                                            <a href='classes/delete.php?step_id=$step_id&project_id=$projeto'><button class='delete-step'>Excluir</button></a>
                                        </div>
                                    </div>

                                    <button class='new-task general'>Nova tarefa</button>
                                    <div class='tasks-form hidden'>
                                        <h3>Nova tarefa</h3>
                                        <form action='controllers/project-tasks-handler.php' method='post'>
                                            <label for='task-name'>Nome da tarefa:</label>
                                            <input name='task-name' id='task-name' type='text' required>

                                            <label for='task-description'>Descrição da tarefa:</label>
                                            <textarea name='task-description' id='task-description'></textarea>

                                            <input type='hidden' name='step_id' id='step_id' value='$step_id'>

                                            <label for='responsible'>Responsável:</label>";

                $collaborators = [];

                $query = "select * from permissions where project_id = ?";
                $types = "i";
                $params = [$projeto];

                $resultCollabs = $DB->read($query, $types, ...$params);

                if($resultCollabs) {
                    foreach($resultCollabs as $row) {

                        $query = "select * from users where session_id = ? limit 1";
                        $types = "s";
                        $params = [$row['session_id']];

                        $resultCollabs = $DB->read($query, $types, ...$params);
                        
                        array_push($collaborators, $resultCollabs[0]);
                    }
                }

                $query = "select * from projects where project_id = ? limit 1";
                $types = "i";
                $params = [$projeto];

                $resultProjects = $DB->read($query, $types, ...$params);

                if ($resultProjects) {
                    $user = $resultProjects[0]['session_id'];

                    $query = "select * from users where session_id = ?";
                    $types = "s";
                    $params = [$user];

                    $resultProjectOwner = $DB->read($query, $types, ...$params);

                    array_push($collaborators, $resultProjectOwner[0]);
                }

                                            echo "<select name='responsible' id='responsible'>
                                            <option value=''>Nenhum</option>";
                                                for ($i = 0; $i < sizeof($collaborators); $i++) {
                                                    echo "<option value='" . $collaborators[$i]['session_id'] . "'>" . $collaborators[$i]['username'] ."</option>";
                                                }
                                            echo "</select>
                                            <button type='submit' name='new-task' class='new-task-create general'>Criar</button>
                                        </form>
                                    </div>
                                    <div class='update-step hidden'>
                                        <form action='controllers/project-tasks-handler.php' method='post'>
                                            <label for='update-step'>Novo nome da etapa</label>
                                            <input type='text' name='update-step' id='update-step' placeholder='Nome da etapa'>

                                            <input type='hidden' name='step-id' value='$step_id'>
                                            <input type='hidden' name='project-id' value='$projeto'>

                                            <button type='button' class='cancel-step-update'>Cancelar</button>
                                            <button type='submit' class='update-step-btn' name='update-step-btn'>Atualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </th>
                        </tr>";

                                $query = "SELECT * FROM tasks WHERE step_id = ? AND project_id = ?";
                                $types = "ii";
                                $params = [$step_id, $projeto];
                                $resultTasks = $DB->read($query, $types, ...$params);

                                if ($resultTasks) {
                                    foreach ($resultTasks as $row) {
                                        $task_name = $row['task_name'];
                                        $task_description = $row['task_description'];
                                        $task_id = $row['task_id'];
                                        $task_owner_image = '';
                                        $task_owner_name = 'Nenhum responsável';

                                        if ($row['responsible_id']) {
                                            $task_responsible = $row['responsible_id'];

                                            $query = "SELECT * FROM users WHERE session_id = ?";
                                            $types = "s";
                                            $params = [$task_responsible];
                                            $resultTaskOwner = $DB->read($query, $types, ...$params);

                                            if ($resultTaskOwner) {
                                                $task_owner_image = $resultTaskOwner[0]['profile_image'];
                                                $task_owner_name = $resultTaskOwner[0]['username'];
                                            }
                                        }

                                        echo"<tr class='task' id='$task_id' draggable='true'>
                                                <td>
                                                    <div class='tasks-btns-flex'>";
                                                    echo "<button type='button' class='task-details'><p>$task_name</button></p>
                                                    <div class='button-group'>
                                                        <button class='edit-task'><img src='imagens/pencil.png' alt=''></button>";

                                                        if ($task_owner_image) {
                                                            echo "<button class='foto-collaborator-btn collab-btn' aria-label='Trocar colaborador'><img src='image-uploads/profile/$task_owner_image' alt=''></button>";
                                                        } else {
                                                            echo "<button class='add-collaborator-btn collab-btn' aria-label='Adicionar colaborador'></button>";
                                                        }
                                                        echo "<button class='del-collaborator-btn' aria-label='Excluir tarefa'><a href='classes/delete.php?task_id=$task_id&project_id=$projeto' class='delete-link'><img class='delete-trash' src='imagens/excluir_icone.png' alt=''></a></button>
                                                        </div>";

                                                        echo "<div class='update-collab hidden'>
                                                        <h3>Designar funcionário</h3>
                                                        <form action='controllers/project-tasks-handler.php' method='post'>
                                                            <label for='responsible'>Responsável:</label>
                                                            <select name='add-responsible' id='responsible'>";
                                                                echo "<option value=''>Nenhum</option>";
                                                                    for ($i = 0; $i < sizeof($collaborators); $i++) {
                                                                        echo "<option value='" . $collaborators[$i]['session_id'] . "'>" . $collaborators[$i]['username'] ."</option>";
                                                                    }
                                                            echo "</select>
                                                            <input type='hidden' name='task-id' value='$task_id'></input>
            
                                                            <button type='button' class='cancel-responsible cancelBtn general'>Cancelar</button>
                                                            <button type='submit' name='update_collaborator' id='update_collaborator' class='general'>Designar</button>
                                                        </form>
                                                        </div>";

                                                        echo "<div class='task-details hidden'>
                                                                <table>
                                                                <tr>
                                                                    <th width='200' height='40'>Tarefa</th>
                                                                    <th width='360' height='40'>Descrição</th>
                                                                    <th width='100' height='40'>Responsável</th>
                                                                </tr>
                                                                <tr>
                                                                    <td height='80'>$task_name</td>
                                                                    <td height='80'>$task_description</td>
                                                                    <td height='80'><div class='task-owner-info'>";
                                                                        if ($task_owner_image != '') {
                                                                        echo "<div class='foto-collaborator-btn'><img class='profile-image' src='image-uploads/profile/$task_owner_image' alt=''></div>";
                                                                        }
                                                                    echo "</div>$task_owner_name
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <button class='hide-task-details general'>Fechar</button>
                                                        </div>";
                                                        
                                                        echo "<div class='task-update hidden'>
                                                            <h3>Atualizar task</h3>
                                                            <form action='controllers/project-tasks-handler.php' method='post'>
                                                                <label for='task-name'>Novo nome da tarefa:</label>
                                                                <input type='text' name='task-name' id='task-name' placeholder='Nome da tarefa' required></input>

                                                                <label for='task-description'>Descrição da tarefa:</label>
                                                                <textarea name='task-description' id='task-description' placeholder='Descrição da tarefa'></textarea>

                                                                <input type='hidden' name='task-id' value='$task_id'></input>

                                                                <label for='responsible'>Mudar responsável:</label>";

                                                                echo "<select name='responsible' id='responsible'>
                                                                    <option value=''>Nenhum</option>";
                                                                        for ($i = 0; $i < sizeof($collaborators); $i++) {
                                                                            echo "<option value='" . $collaborators[$i]['session_id'] . "'>" . $collaborators[$i]['username'] ."</option>";
                                                                        }
                                                                    echo "</select>
                                                                    <button type='button' class='cancel-task-update cancelBtn general' name='cancel-task-update'>Cancelar</button>
                                                                    <button type='submit' name='update-task' id='update-task' class='general'>Atualizar</button>

                                                            </form>
                                                        </div>";

                                                echo "</div>
                                                </td>
                                            </tr>";

                                    }
                                } else {
                                    echo"<tr>
                                            <td>
                                                <div class='tasks-btns-flex'>";
                                                echo "<p>Não há tarefas para exibir.</p>";
                                            echo "</div> <!-- Fechando a div tasks-btns-flex -->
                                            </td>
                                        </tr>";
                                }

                                echo "
                    </table>
                </div>";
                
            }
        } else {

        }
        // echo "<pre>";
        // print_r($collaborators);
        // echo "</pre>";
        ?>

    </main>

    <?php include('partials/footer.php') ?>

    <script src="js/project-tasks.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
