<?php
    session_start();

    $error = '';

    include('connect.php');

    if (isset($_SESSION['collab_sessionid'])) {
        $session_id = $_SESSION['collab_sessionid'];
        if (isset($_GET['delete_id'])) {
            $project_id = $_GET['delete_id'];

            $query = "SELECT project_image FROM projects WHERE project_id = ? AND session_id = ?";
            $types = "is";
            $params = [$project_id, $session_id];
            $DB = new Database();

            $result_image = $DB->read($query, $types, ...$params);
            $image_path = $result_image['0']['project_image'];
            define('ROOT_DIR', realpath(__DIR__ . '/../'));

            $full_image_path = ROOT_DIR . '/uploads/' . $image_path;


            $query = "delete from projects where project_id = ? and session_id = ?";
            $types = "is";
            $params = [$project_id, $session_id];

            $DB = new Database();
            $result_delete = $DB->save($query, $types, ...$params);

            if (file_exists($full_image_path) && $image_path  != 'default.png') {

                chmod($full_image_path, 0777);
                unlink($full_image_path);
            }

            header('Location: ../projects.php');

        }
    } else {
        header('Location: ../login.php');
    }

?>