<?php
require_once __DIR__ . '/../../config/Database.php';

class Artwork {
    private $conn;
    private $table = "artworks";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($artist_id, $title, $description, $image_url, $starting_price) {
        $query = "INSERT INTO " . $this->table . " 
                  (artist_id, title, description, image_url, starting_price, auction_start_time, auction_end_time) 
                  VALUES (:artist_id, :title, :description, :image_url, :starting_price, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artist_id", $artist_id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":starting_price", $starting_price);

        return $stmt->execute();
    }

    public function findByArtist($artist_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE artist_id = :artist_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artist_id", $artist_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  LEFT JOIN users u ON a.artist_id = u.id 
                  WHERE a.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  LEFT JOIN users u ON a.artist_id = u.id 
                  ORDER BY a.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAvailable() {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  LEFT JOIN users u ON a.artist_id = u.id 
                  WHERE a.status = 'available' 
                  ORDER BY a.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findInAuction() {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  LEFT JOIN users u ON a.artist_id = u.id 
                  WHERE a.status = 'in_auction' AND a.auction_end_time > NOW() 
                  ORDER BY a.auction_end_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":status", $status);
        return $stmt->execute();
    }

    public function updateCurrentBid($id, $bid_amount) {
        $query = "UPDATE " . $this->table . " SET current_bid = :bid_amount WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":bid_amount", $bid_amount);
        return $stmt->execute();
    }

    public function markAsSold($id, $buyer_id, $final_price) {
        $query = "UPDATE " . $this->table . " 
                  SET status = 'sold', buyer_id = :buyer_id, final_sale_price = :final_price 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":buyer_id", $buyer_id);
        $stmt->bindParam(":final_price", $final_price);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function startAuction($id) {
        $query = "UPDATE " . $this->table . " 
                  SET status = 'in_auction', auction_start_time = NOW(), auction_end_time = DATE_ADD(NOW(), INTERVAL 7 DAY) 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function findByBuyer($buyer_id) {
        $query = "SELECT a.*, u.name as artist_name FROM " . $this->table . " a 
                  LEFT JOIN users u ON a.artist_id = u.id 
                  WHERE a.buyer_id = :buyer_id AND a.status = 'sold'
                  ORDER BY a.updated_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":buyer_id", $buyer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>