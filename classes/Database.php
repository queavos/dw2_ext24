<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if ($this->conn->connect_error) {
                throw new Exception('Connection failed: ' . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
