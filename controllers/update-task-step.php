<?php
session_start();
include("../classes/connect.php");

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
error_log(print_r($data, true));
$taskId = $data['task-id'];
$newStepId = $data['newStepId'];

if (isset($taskId) && isset($newStepId)) {
    $query = "UPDATE tasks SET step_id = ? WHERE task_id = ?";
    $types = "ii";
    $params = [$newStepId, $taskId];

    $DB = new Database();
    $DB->connect();
    
    $result = $DB->save($query, $types, ...$params);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a tarefa']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
}