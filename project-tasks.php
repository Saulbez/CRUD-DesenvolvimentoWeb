<?php

    $projeto = $_GET['project_id'];
    print_r($projeto);
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

    
</head>



<body>

    <?php include('partials/header.php') ?>

    <main>
        <h2>Gerenciar tarefas</h2>
        <div class="form-wrapper">
            <form action="" method="post">
                <label for="add_task">Adicionar tarefa</label>
                <input type="text" id="add_task" name="add_task">
                <button type="submit" name="submit" class="add_task_button">Adicionar</button>
            </form>
        </div>

        <div id='tables-wrapper'>
            <div class="table-wrapper">
                <table class="to-do">
                    <tr>
                        <th>To do</th>
                    </tr>
                    <tr>
                        <td>Teste</td>
                    </tr>
                </table>
            </div>
            <div class="table-wrapper">
                <table class="in-progress">
                    <tr>
                        <th>In progress</th>
                    </tr>
                    <tr>
                        <td>Teste</td>
                    </tr>
                </table>
            </div>
            <div class="table-wrapper">
                <table class="done">
                    <tr>
                        <th>Done</th>
                    </tr>
                    <tr>
                        <td>Teste</td>
                    </tr>
                </table>
            </div>
        </div>

    </main>

    <?php include('partials/footer.php') ?>

</body>
</html>

