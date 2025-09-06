<?php
require_once __DIR__ . '/../config/Database.php';

class Artwork {
    private $conn;
    private $table = "artworks";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($artist_id, $title, $description, $image_path, $initial_price) {
        $query = "INSERT INTO " . $this->table . " 
                  (artist_id, title, description, image_path, initial_price, current_price) 
                  VALUES (:artist_id, :title, :description, :image_path, :initial_price, :initial_price)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artist_id", $artist_id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image_path", $image_path);
        $stmt->bindParam(":initial_price", $initial_price);
        
        return $stmt->execute();
    }

    public function findByArtistId($artist_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE artist_id = :artist_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artist_id", $artist_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  JOIN users u ON a.artist_id = u.id 
                  WHERE a.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAvailable() {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  JOIN users u ON a.artist_id = u.id 
                  WHERE a.status = 'available' 
                  ORDER BY a.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCurrentPrice($id, $new_price) {
        $query = "UPDATE " . $this->table . " SET current_price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":price", $new_price);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function getArtworkWithBids($artwork_id) {
        $query = "SELECT a.*, u.name as artist_name,
                         b.id as bid_id, b.bid_amount, b.status as bid_status, 
                         b.created_at as bid_created_at, bu.name as buyer_name
                  FROM " . $this->table . " a 
                  JOIN users u ON a.artist_id = u.id 
                  LEFT JOIN bids b ON a.id = b.artwork_id AND b.status = 'pending'
                  LEFT JOIN users bu ON b.buyer_id = bu.id
                  WHERE a.id = :artwork_id
                  ORDER BY b.bid_amount DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artwork_id", $artwork_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>