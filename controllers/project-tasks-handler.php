<?php
session_start();

include ("../classes/connect.php");

$etapa = $_POST['add_step'];
$error = '';
$project_id = $_SESSION['project_id'];

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
    $DB->save($query, $types, ...$params);
    header("Location: ../project-tasks.php?project_id=" . "$project_id");
    exit();
}

?>