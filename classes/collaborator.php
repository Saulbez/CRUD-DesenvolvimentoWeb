<?php

class Collab {

    private $error = '';

    private $db;

    public function project_exists($data, $id) {
        $query = "select * from projects where project_id = ? and session_id = ?";
        $types = "is";
        $params = [$data['projeto_colaborador'], $id];

        $this->db = new Database();
        $result_project =  $this->db->read($query, $types, ...$params);

        if ($result_project) {
            $query = "select * from users where lower(username) like lower(?) limit 1";
            $types = "s";
            $params = [$data['colaborador']];

            $result_collaborator =  $this->db->read($query, $types, ...$params);

            if ($result_collaborator) {

                // Check if permission already exists
                $query = "select * from permissions where session_id = ? and project_id = ?";
                $types = "si";
                $params = [$result_collaborator[0]['session_id'], $result_project[0]['project_id']];

                $existing_permission = $this->db->read($query, $types, ...$params);

                if (!$existing_permission) {
                    
                    // Permission doesn't exist, so insert it
                    $query = "insert into permissions (session_id, project_id, permission_type) values (?, ?, ?)";
                    $types = "sis";
                    $params = [$result_collaborator[0]['session_id'], $result_project[0]['project_id'], $data['permissao']];
    
                    $this->db->save($query, $types, ...$params);
                } else {
                    // Permission already exists, you might want to update it instead
                    $query = "update permissions set permission_type = ? where session_id = ? and project_id = ?";
                    $types = "ssi";
                    $params = [$data['permissao'], $result_collaborator[0]['session_id'], $result_project[0]['project_id']];
    
                    $this->db->save($query, $types, ...$params);
                }
    
            }
            return true;
        } else {
            return false;
        }
    }

    public function check_permission($session_id, $project_id) {
        $query = "select * from permissions where session_id = ? and project_id = ?";
        $types = "si";
        $params = [$session_id, $project_id];

        $this->db = new Database();
        $projects_collaborating_permissions = $this->db->read($query, $types, ...$params);
        if ($projects_collaborating_permissions) {
            return $projects_collaborating_permissions;
        } else {
            return [];
        }
    }

    public function get_participants($project_id) {

        $query = "SELECT * FROM permissions WHERE project_id = ?";
        $types = "i";
        $params = [$project_id];
    
        $this->db = new Database();
        $permissions = $this->db->read($query, $types, ...$params);
    
        $participants = [];
    
        if ($permissions) {
            foreach ($permissions as $permission) {
                $query = "SELECT username FROM users WHERE session_id = ?";
                $types = "s";
                $params = [$permission['session_id']]; // Correct access to sessions_id
    
                $usernameResult = $this->db->read($query, $types, ...$params);
                
                // Assuming usernameResult returns an array
                if ($usernameResult && isset($usernameResult[0]['username'])) {
                    $participants[] = $usernameResult[0]['username']; // Extract username
                }
            }
        }
        return $participants;
    }
}

?>