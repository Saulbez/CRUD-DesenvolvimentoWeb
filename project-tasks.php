<?php
session_start();

include("classes/connect.php");

$projeto = $_GET['project_id'];

$_SESSION['project_id'] = $projeto;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nome do projeto</title>

    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/project-tasks.css">
    <link rel="stylesheet" href="styles/button.css">
    
</head>

<body>

    <?php include('partials/header.php') ?>

    <main>
        <h2>Gerenciar tarefas</h2>
        <div class="form-wrapper">
            <form action="controllers/project-tasks-handler.php" method="post">
                <label for="add_task">Nova etapa</label>
                <input type="text" id="add_step" name="add_step">
                <button type="submit" name="submit" class="add_step_button">Adicionar</button>
            </form>
        </div>
        <?php 

        $query = "select * from steps where project_id = ?";
        $types = "i";
        $params = [$projeto];

        $DB = new Database();
        $result = $DB->read($query, $types, ...$params);

        if($result) {
            echo "<div id='tables-wrapper'>";

            for ($i = 0; $i < sizeof($result); $i++) {
                $step_title = $result[$i]['step_title'];
                echo "<div class='table-wrapper'>
                    <table class='to-do'>
                        <tr>
                            <th>$step_title</th>
                        </tr>
                        <tr>
                        <td>
                            <div class='tasks-btns-flex'>
                                <p>Teste</p>
                                <div class='button-group'>
                                    <button class='foto-collaborator-btn' onclick='AdicionarColaborador()' aria-label='Adicionar colaborador'></button>
                                    <button class='add-collaborator-btn' onclick='AdicionarColaborador()' aria-label='Adicionar colaborador'></button>
                                    <button class='del-collaborator-btn' onclick='AdicionarColaborador()' aria-label='Excluir colaborador'></button>
                                </div>
                            </div>
                        </td>
                        </tr>
                    </table>
                </div>";
            }
        } else {
            echo "<p>Não há tarefas para exibir.</p>";
        }
        ?>
        </div>

    </main>

    <?php include('partials/footer.php') ?>
</body>
</html>
