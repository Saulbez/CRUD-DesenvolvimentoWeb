<?php

class Database 
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "collab";

    private $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    
    function read($query, $types, ...$params) {
        $conn = $this->connection;

        if(isset($query)) {
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            if ($types && $params) { 
                $stmt->bind_param($types, ...$params); 
            }

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $data = false;
                while($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }

                return $data;
            } else {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
        }
    }
    
    function save($query, $types, ...$params) {
        $conn = $this->connection;

        if(isset($query)) {
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            if ($types && $params) { 
                $stmt->bind_param($types, ...$params); 
            }

            if ($stmt->execute()) {
                return $stmt;
            } else {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
        }
    }

    function getLastInsertId() {
        return $this->connection->insert_id; // Retorna o ID do último registro inserido
    }

}