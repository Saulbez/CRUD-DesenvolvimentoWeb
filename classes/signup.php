<?php

class Signup{

    private $error = "";

    public function evaluate($data) {
        foreach ($data as $key => $value) {

            if (empty($value)) {
                $this->error = "Por favor preencha o campo $key.<br>";
            }

            if ($key == "username") {

                if (is_numeric($value)) {

                $this->error = "O nome não deve ser numérico.";
                }

                if (strstr($value, " ")) {
                    $this->error = "O nome não deve conter espaços.";
                }

            }

            if ($key == "email") {
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {

                $this->error = "Por favor, digite um endereço de email válido!<br>";
                }
            }

            if ($key == "password") {

                if (strlen($value) < 6) {
                    $this->error = "A senha deve ser no mínimo 6 dígitos.";
                }
            }

        }

        if (!$this->error) {
            $result = $this->create_user($data);
            return $result;
        } else {
            return $this->error;
        }
    }

    public function create_user($data) {

        $username = ucfirst($data['username']);
        $email = $data['email'];
        $password = $data['password'];
        $session_id = $this->create_sessionid();

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = ("insert into users (session_id, username, email, user_password) values (?, ?, ?, ?)");
        
        $types = "ssss";

        $params = ["$session_id", "$username", "$email", "$hashed_password"];
        
        $DB = new Database();
        $DB->connect();
        $result = $DB->save($query, $types, ...$params);
        
        if ($result) {
            return true;
        } else {
            return $result;
        }
    }

    private function create_sessionid() {

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

}