<?php

class DBConn extends PDO {

    private $conn;

    public function __construct() {
        $this->conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0", "sa", "root");
    }

    private function setParams($parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->setParam($key, $value);
        }
    }

    private function setParam($statement, $key, $value) {
        $statement->bindParam($key, $value);
    }

    public function query($RawQuery, $params = array()) {
        $stmt = $this->conn->prepare($RawQuery);

        $this->setParams($stmt, $params);
        
        $stmt->execute();
        return $stmt;
    }
    
    public function select($RawQuery, $params = array()) : array{
        $stmt = $this->query($RawQuery, $params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>