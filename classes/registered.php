<?php

class User {

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
                }
            }
        }
        if ($image) {

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
        } else {
            $result = this->create_project(null, $project, $id);
        }

        if ($result) {
            return $result;
        } else {
            return $this->error;
            echo $this->error;
        }
    }


    private function create_project($image_name, $project_data, $id) {

        if ($image_name) {
            $session_id = $id;

            $project_name = $project_data['project-name'];
            $project_description = $project_data['project-description'];
            $project_image = $image_name;

            $DB = new Database();

            $query = "insert into projects (session_id, project_name, project_description, project_image) values (?, ?, ?, ?)";

            $types = "ssss";
            $params = ["$session_id", "$project_name", "$project_description", "$project_image"];

            if ($DB->save($query, $types, ...$params)) {
                return $this->error; // Project created successfully
            } else {
                $this->error .= "An error occurred while saving the project.";
            }
        } else {
            $session_id = $id;

            $project_name = $project_data['project-name'];
            $project_description = $project_data['project-description'];
            $project_image = "default.png";

            $DB = new Database();

            $query = "insert into projects (session_id, project_name, project_description, project_image) values (?, ?, ?, ?)";

            $types = "ssss";
            $params = ["$session_id", "$project_name", "$project_description", "$project_image"];

            if ($DB->save($query, $types, ...$params)) {
                return $this->error; // Project created successfully
            } else {
                $this->error .= "An error occurred while saving the project.";
            }
        }
        return $this->error;
    }
}