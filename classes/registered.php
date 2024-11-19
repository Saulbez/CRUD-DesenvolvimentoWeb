<?php

class User {

    private $numeric = "";
    private $error= "";
    private $working = "";

    public function get_projects($id) {

        $query = "select project_id from permissions where session_id = ?";
        $types = "s";
        $params = [$id];

        $DB = new Database();
        $DB->connect();
        $result_collaboration = $DB->read($query, $types, ...$params);

        if ($result_collaboration) {
            $query = "select * from projects where session_id = ?";
            $types = "s";
            $params = ["$id"];

            $personal_projects = $DB->read($query, $types, ...$params);

            $projects = [];

            if ($personal_projects && is_array($personal_projects)) {
                for ($i=0; $i<count($personal_projects); $i++) {
                    array_push($projects, $personal_projects[$i]);
                }
            }

            if ($result_collaboration && is_array($result_collaboration)) {
                for ($i=0; $i<count($result_collaboration); $i++) {
                    $query = "select * from projects where project_id = ?";
                    $types = "i";
                    $params = [$result_collaboration[$i]['project_id']];

                    $result = $DB->read($query, $types, ...$params);
                    if ($result && is_array($result)) {
                        for ($j=0; $j<count($result); $j++) {
                            array_push($projects, $result[$j]);
                        }
                    }
                }
            }

            if($projects) {
                return $projects;
            } else {
                return false;
            }

        } else {
            $query = "select * from projects where session_id = ?";
            $types = "s";
            $params = ["$id"];
            $DB->connect();
            $result = $DB->read($query, $types, ...$params);

            if($result) {

                return $result;
            } else {
                return false;
            }
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
        if ($image && !$this->numeric) {

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
                        $img_upload_path = 'image-uploads/projects/'.$new_img_name;
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
        $DB->connect();

        $session_id = $id;
        $project_id = isset($project_data['update_id']) ? $project_data['update_id'] : null;
    
        if ($project_id) {

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
                $this->error .= "Nenhum campo para atualizar.";
                return $this->error;
            }
    
            $query .= implode(", ", $updates);
            $query .= " where project_id = ? AND session_id = ?";
            $types .= "is";
            $params[] = $project_id;
            $params[] = $session_id;

            $result = $DB->save($query, $types, ...$params);

            if($result) {
                $this->working = "Projeto atualizado!";
                return $this->working;
            }
    
        } else {

            $query = "insert into projects (session_id, project_name, project_description, project_image) values (?, ?, ?, ?)";
            $types = "ssss";
            $params = [
                $session_id,
                $project_data['project-name'] ?? '',
                $project_data['project-description'] ?? '',
                $image_name ?: 'default.png'
            ];

            $result = $DB->save($query, $types, ...$params);

            if($result) {
                echo "true";
                $project_id = $DB->getLastInsertId();
                echo $project_id;

                $step_titles = ["Por fazer", "Em progresso", "Concluído"];

                for ($i = 0; $i < sizeof($step_titles); $i++) {
                    $current_title = $step_titles[$i];

                    $query = "insert into steps (project_id, step_title) values (?, ?)";
                    $types = "ss";
                    $params = [$project_id, $current_title];

                    $DB->save($query, $types, ...$params);
                }

            } else {
                echo "false";
                $this->error .= "Houve um erro ao salvar o projeto.";
            }
        }
    
        if ($result) {
            return true;

        } else {
            $this->error .= "Houve um erro ao salvar o projeto.";
            return false;
        }
    }

}