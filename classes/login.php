<?php

    class Login {

        private $error = "";

        public function evaluate($data) {

            $email = addslashes($data['email']);
            $password = addslashes($data['password']);
    
            $query = "select * from users where email = ? limit 1";

            $types = "s";

            $params = ["$email"];

            $DB = new Database();
            $result = $DB->read($query, $types, ...$params);

            if ($result) {

                $row = $result[0];

                if ($password == $row['user_password']) {

                    //create session data
                    $_SESSION['collab_sessionid'] = $row['session_id'];

                } else {

                    $this->error .= "Email ou senha inválidos<br>";
    
                }

            } else {

                $this->error .= "Email ou senha inválidos<br>";

            }

            return $this->error;

        }

        public function check_login($id) {

            $query = "select session_id from users where session_id = ? limit 1";

            $types = "s";
            $params = ["$id"];

            $DB = new Database();
            $result = $DB->read($query, $types, ...$params);

            if($result) {
                return true;
            }

            return false;
        }

    }

?>