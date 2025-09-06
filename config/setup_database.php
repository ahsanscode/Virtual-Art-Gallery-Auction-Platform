<?php
require_once 'Database.php';

class DatabaseSetup {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function setupTables() {
        $this->createUsersTable();
        $this->createArtworksTable();
        $this->createBidsTable();
        echo "Database tables created successfully!\n";
    }
    
    private function createUsersTable() {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) DEFAULT 'buyer',
            is_deleted INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->conn->exec($query);
        echo "Users table created/verified.\n";
    }
    
    private function createArtworksTable() {
        $query = "CREATE TABLE IF NOT EXISTS artworks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            artist_id INTEGER NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            image_path VARCHAR(500),
            initial_price DECIMAL(10,2) NOT NULL,
            current_price DECIMAL(10,2) DEFAULT NULL,
            status VARCHAR(20) DEFAULT 'available',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (artist_id) REFERENCES users(id)
        )";
        
        $this->conn->exec($query);
        echo "Artworks table created/verified.\n";
    }
    
    private function createBidsTable() {
        $query = "CREATE TABLE IF NOT EXISTS bids (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            artwork_id INTEGER NOT NULL,
            buyer_id INTEGER NOT NULL,
            bid_amount DECIMAL(10,2) NOT NULL,
            status VARCHAR(20) DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (artwork_id) REFERENCES artworks(id),
            FOREIGN KEY (buyer_id) REFERENCES users(id)
        )";
        
        $this->conn->exec($query);
        echo "Bids table created/verified.\n";
    }
}

// Run setup if called directly
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    $setup = new DatabaseSetup();
    $setup->setupTables();
}
?>