<?php

    class Login {

        private $error = "";

        public function evaluate($data) {

            $email = addslashes($data['email']);
            $password = $data['password'];
    
            $query = "select * from users where email = ? limit 1";

            $types = "s";

            $params = ["$email"];

            $DB = new Database();
            $DB->connect();
            $result = $DB->read($query, $types, ...$params);

            if ($result) {

                $row = $result[0];
                $hashed_password = $row['user_password'];

                if (password_verify($password, $hashed_password)) {

                    $_SESSION['collab_sessionid'] = $row['session_id'];
                    $this->error = true;

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
            $DB->connect();
            $result = $DB->read($query, $types, ...$params);

            if($result) {
                return true;
            }

            return false;
        }

    }

?>