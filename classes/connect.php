<?php

class Database 
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "collab";

    function connect() {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);

        return $connection;
    }
    
    function read($query, $types, ...$params) {
        $conn = $this->connect();
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
    
    function save($query, $types = "", ...$params) {
        $conn = $this->connect();
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        if ($types && $params) { 
            $stmt->bind_param($types, ...$params); 
        }

        if ($stmt->execute()) {
            return $stmt; // Return the statement for result handling
        } else {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

    }

}