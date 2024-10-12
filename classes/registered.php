<?php

class User {

    private $numeric = "";
    private $error= "";

    public function get_projects($id) {

        $query = "select * from projects where session_id = ?";

        $types = "s";
        $params = ["$id"];

        $projects = [];

        $DB = new Database();
        $result = $DB->read($query, $types, ...$params);

        if($result) {

            return $result;
        } else {
            return false;
        }

    }

    public function project_evaluate($image, $project, $id) {
        foreach ($project as $key => $value) {
            if ($key == 'project-name') {
                if (is_numeric($value)) {
                    $this->error.= "O nome do projeto não pode ser um número.<br>";
                    $this->numeric .= 1;
                }
            }
        }
        if ($image && !$numeric) {

            $result = "";

            $img_name = $image['name'];
            $img_ext = $image['type'];
            $img_size = $image['size'];
            $tmp_name = $image['tmp_name'];
            $img_error = $image['error'];

            if ($img_error === 0) {
                $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ext);

                $allowed_exts = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exts)) {

                    if ($img_size > 12500000) {
                        $em = "Desculpe, seu arquivo é grande demais.";
                        $this->error.= "$em<br>";
                    } else {
                        $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                        $img_upload_path = 'uploads/'.$new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);

                        $result = $this->create_project($new_img_name, $project, $id);
                    }
                } else {
                    $em = "Desculpe, apenas imagens são permitidas.";
                    $this->error.= "$em<br>";
                }
            }
        } elseif (!$numeric) {
            $result = $this->create_project($image, $project, $id);
        }

        if ($result) {
            return $result;
        } else {
            return $this->error;
            echo $this->error;
        }
    }


    private function create_project($image_name, $project_data, $id) {
        $DB = new Database();
        $session_id = $id;
        $update_id = isset($project_data['update_id']) ? $project_data['update_id'] : null;
    
        if ($update_id) {
            // This is an update operation
            $query = "update projects set ";
            $types = "";
            $params = [];
            $updates = [];
    
            if (isset($project_data['project-name']) && $project_data['project-name'] !== '') {
                $updates[] = "project_name = ?";
                $types .= "s";
                $params[] = $project_data['project-name'];
            }
    
            if (isset($project_data['project-description']) && $project_data['project-description'] !== '') {
                $updates[] = "project_description = ?";
                $types .= "s";
                $params[] = $project_data['project-description'];
            }
    
            if ($image_name) {
                $updates[] = "project_image = ?";
                $types .= "s";
                $params[] = $image_name;
            }
    
            if (empty($updates)) {
                $this->error .= "No fields to update.";
                return false;
            }
    
            $query .= implode(", ", $updates);
            $query .= " where project_id = ? AND session_id = ?";
            $types .= "is";
            $params[] = $update_id;
            $params[] = $session_id;
    
        } else {
            // This is an insert operation
            $query = "insert into projects (session_id, project_name, project_description, project_image) values (?, ?, ?, ?)";
            $types = "ssss";
            $params = [
                $session_id,
                $project_data['project-name'] ?? '',
                $project_data['project-description'] ?? '',
                $image_name ?: 'default.png'
            ];
        }
    
        if ($DB->save($query, $types, ...$params)) {
            return true; // Project created/updated successfully
        } else {
            $this->error .= "An error occurred while saving the project.";
            return false;
        }
    }

    // private function deleteProject($project_id, $session_id) {

    //     $query = "delete from projects where project_id = ? AND session_id = ?";
    //     $types = "is";
    //     $params = [$project_id, $session_id];

    //     if($DB->save($query, $types, ...$params)) {
    //         return true;
    //     } else {
    //         $this->error .= "An error occurred while deleting the project.";
    //         return false;
    //     }
    // }

}