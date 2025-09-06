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
            
            // Initialize missing tables only if we have a valid connection
            if ($this->conn) {
                $this->initializeTables();
            }
        } catch(PDOException $exception) {
            // Log the error but don't crash the application
            error_log("Database connection error: " . $exception->getMessage());
            $this->conn = null;
        }
        return $this->conn;
    }

    private function initializeTables() {
        try {
            // Check if we're using SQLite or MySQL
            $driver = $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
            
            if ($driver === 'sqlite') {
                // For SQLite, check if bids table exists
                $result = $this->conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='bids'");
                if ($result->rowCount() == 0) {
                    $this->createBidsTableSQLite();
                }
            } else {
                // For MySQL, use SHOW TABLES
                $result = $this->conn->query("SHOW TABLES LIKE 'bids'");
                if ($result->rowCount() == 0) {
                    $this->createBidsTable();
                }
            }
        } catch(PDOException $exception) {
            // Silently fail if we can't check/create tables
            // This ensures the application doesn't crash
        }
    }

    private function createBidsTableSQLite() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS bids (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                artwork_id INTEGER NOT NULL,
                bidder_id INTEGER NOT NULL,
                bid_amount DECIMAL(10,2) NOT NULL,
                bid_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (artwork_id) REFERENCES artworks(id) ON DELETE CASCADE,
                FOREIGN KEY (bidder_id) REFERENCES users(id)
            )";
            
            $this->conn->exec($sql);
        } catch(PDOException $exception) {
            // Silently fail if we can't create the table
        }
    }

    private function createBidsTable() {
        try {
            $sql = "CREATE TABLE `bids` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `artwork_id` int(11) NOT NULL,
                `bidder_id` int(11) NOT NULL,
                `bid_amount` decimal(10,2) NOT NULL,
                `bid_time` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `artwork_id` (`artwork_id`),
                KEY `bidder_id` (`bidder_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
            
            $this->conn->exec($sql);
            
            // Add foreign key constraints if tables exist
            try {
                $this->conn->exec("ALTER TABLE `bids` ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`artwork_id`) REFERENCES `artworks` (`id`) ON DELETE CASCADE");
                $this->conn->exec("ALTER TABLE `bids` ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`bidder_id`) REFERENCES `users` (`id`)");
            } catch(PDOException $e) {
                // Ignore foreign key constraint errors if referenced tables don't exist
            }
        } catch(PDOException $exception) {
            // Silently fail if we can't create the table
        }
    }
}
?>