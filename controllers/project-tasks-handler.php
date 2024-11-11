<?php
session_start();

include ("../classes/connect.php");

$etapa = '';
if(isset($_POST['add_step'])) {
    $etapa = $_POST['add_step'];
}

$error = '';
$project_id = $_SESSION['project_id'];

if($etapa) {
    if (is_numeric($etapa)) {
        $error = "O nome da etapa não deve ser numérico.";
        $_SESSION['add_step_error'] = $error;
        header("Location: ../project-tasks.php?project_id=" . "$project_id");
        exit();
    } else {
        $query = "insert into steps (project_id, step_title) values (?, ?)";
        $types = "is";
        $params = [$project_id, $etapa];

        $DB = new Database();
        $DB->connect();
        $DB->save($query, $types, ...$params);
        header("Location: ../project-tasks.php?project_id=" . "$project_id");
        exit();
    }
} else if (isset($_POST['new-task'])) {
    $taskName = $_POST['task-name'];
    $taskDescription = $_POST['task-description'];
    $responsible = $_POST['responsible'];
    $step_id = $_POST['step_id'];

    if(is_numeric($taskName)) {
        $error = "O nome da tarefa não deve ser numérico.";
        $_SESSION['new_task_error'] = $error;
        header("Location: ../project-tasks.php?project_id=" . "$project_id");
        exit();
    } else {
        if($responsible && $responsible != '') {
            $query = "insert into tasks (step_id, project_id, responsible_id, task_name, task_description) values (?, ?, ?, ?, ?)";
            $types ="iisss";
            $params = [$step_id, $project_id, $responsible, $taskName, $taskDescription];

            $DB = new Database();
            $DB->connect();
            $result = $DB->save($query, $types, ...$params);
            header("Location: ../project-tasks.php?project_id=" . "$project_id");
            exit();
        } else {
            $query = "insert into tasks (step_id, project_id, task_name, task_description) values (?, ?, ?, ?)";
            $types ="iiss";
            $params = [$step_id, $project_id, $taskName, $taskDescription];

            $DB = new Database();
            $DB->connect();
            $result = $DB->save($query, $types, ...$params);
            header("Location: ../project-tasks.php?project_id=" . "$project_id");
            exit();
        }
    }
} elseif (isset($_POST['add-responsible'])) {
    $responsible_id = $_POST['add-responsible'];
    $task_id = $_POST['task-id'];

    if ($responsible_id === '') {
        $responsible_id = null;
    }

    $query = "update tasks set responsible_id = ? where task_id = ?";
    $types = "si";
    $params = [$responsible_id, $task_id];

    $DB = new Database();
    $DB->connect();
    $result = $DB->save($query, $types, ...$params);
    header("Location: ../project-tasks.php?project_id=" . "$project_id");
    exit();

} elseif (isset($_POST['update-task'])) {
    $task_id = $_POST['task-id'];
    $task_name = $_POST['task-name'];
    $task_description = $_POST['task-description'];
    $responsible_id = $_POST['responsible']; // Obtém o valor do responsável

    // Verifica se o responsável é uma string vazia e define como null
    if ($responsible_id === '') {
        $responsible_id = null; // Define como null se "Nenhum" for selecionado
    }

    $query = "UPDATE tasks SET task_name = ?, task_description = ?, responsible_id = ? WHERE task_id = ?";
    $types = "sssi";
    $params = [$task_name, $task_description, $responsible_id, $task_id];

    $DB = new Database();
    $DB->connect();
    $result = $DB->save($query, $types, ...$params);
    header("Location: ../project-tasks.php?project_id=" . "$project_id");
    exit();
}

?>