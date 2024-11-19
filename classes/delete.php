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
            $DB->connect();

            $result_image = $DB->read($query, $types, ...$params);
            $image_path = $result_image['0']['project_image'];
            define('ROOT_DIR', realpath(__DIR__ . '/../'));

            $full_image_path = ROOT_DIR . '/image-uploads/projects/' . $image_path;

            $query = "delete from projects where project_id = ? and session_id = ?";
            $types = "is";
            $params = [$project_id, $session_id];

            $result_delete = $DB->save($query, $types, ...$params);

            $_SESSION['delete_result'] = $result_delete;

            if (file_exists($full_image_path) && $image_path  != 'default.png') {

                chmod($full_image_path, 0777);
                unlink($full_image_path);
            }

            header('Location: ../projects.php');

        } elseif (isset($_GET['task_id'])) {
            $project_id = $_GET['project_id'];
            $task_id = $_GET['task_id'];
    
            $query = "delete from tasks where task_id = ? limit 1";
            $types = "i";
            $params = [$task_id];
    
            $DB = new Database();
            $DB->connect();
    
            $result_delete = $DB->save($query, $types, ...$params);

            $_SESSION['delete_result'] = $result_delete;
    
            header("Location: ../project-tasks.php?project_id=$project_id");
        } elseif (isset($_GET['collaborator_id'])) {
            $project_id = $_GET['project_id'];
            $collaborator_id = $_GET['collaborator_id'];

            $query = "delete from permissions where session_id = ? and project_id = ?";
            $types = "si";
            $params = [$collaborator_id, $project_id];

            $DB = new Database();
            $DB->connect();
    
            $result_delete = $DB->save($query, $types, ...$params);

            $_SESSION['delete_result'] = $result_delete;

            header("Location: ../projects.php");
        } elseif (isset($_GET['step_id'])) {
            $step_id = $_GET['step_id'];
            $project_id = $_GET['project_id'];

            $query = "delete from steps where step_id = ? limit 1";
            $types = "i";
            $params = [$step_id];

            $DB = new Database();
            $DB->connect();

            $result_delete = $DB->save($query, $types, ...$params);

            $_SESSION['delete_result'] = $result_delete;

            header("Location: ../project-tasks.php?project_id=$project_id");
        }

    } else {
        header('Location: ../login.php');
    }

?>