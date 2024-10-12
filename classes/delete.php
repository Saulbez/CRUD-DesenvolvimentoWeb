<?php
    session_start();

    $error = '';

    include('connect.php');

    if (isset($_SESSION['collab_sessionid'])) {
        $session_id = $_SESSION['collab_sessionid'];
        if (isset($_GET['delete_id'])) {
            $project_id = $_GET['delete_id'];


            $query = "delete from projects where project_id = ? and session_id = ?";
            $types = "is";
            $params = [$project_id, $session_id];

            $DB = new Database();
            $result = $DB->save($query, $types, ...$params);

            header('Location: ../projects.php');

        }
    } else {
        header('Location: ../login.php');
    }

?>