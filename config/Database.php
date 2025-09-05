<?php
class Database {
    private $host = "localhost";
    private $db_name = "virtual_art_gallery";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // For testing purposes, use SQLite
            if (file_exists(__DIR__ . '/../test_db.sqlite')) {
                $this->conn = new PDO("sqlite:" . __DIR__ . "/../test_db.sqlite");
            } else {
                // Fallback to MySQL if SQLite doesn't exist
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                    $this->username, 
                    $this->password
                );
            }
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>