<?php
require_once __DIR__ . '/../config/Database.php';

class Bid {
    private $conn;
    private $table = "bids";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($artwork_id, $buyer_id, $bid_amount) {
        $query = "INSERT INTO " . $this->table . " 
                  (artwork_id, buyer_id, bid_amount) 
                  VALUES (:artwork_id, :buyer_id, :bid_amount)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artwork_id", $artwork_id);
        $stmt->bindParam(":buyer_id", $buyer_id);
        $stmt->bindParam(":bid_amount", $bid_amount);
        
        return $stmt->execute();
    }

    public function findByArtworkId($artwork_id) {
        $query = "SELECT b.*, u.name as buyer_name FROM " . $this->table . " b 
                  JOIN users u ON b.buyer_id = u.id 
                  WHERE b.artwork_id = :artwork_id 
                  ORDER BY b.bid_amount DESC, b.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artwork_id", $artwork_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByBuyerId($buyer_id) {
        $query = "SELECT b.*, a.title as artwork_title, a.image_path, u.name as artist_name 
                  FROM " . $this->table . " b 
                  JOIN artworks a ON b.artwork_id = a.id 
                  JOIN users u ON a.artist_id = u.id 
                  WHERE b.buyer_id = :buyer_id 
                  ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":buyer_id", $buyer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHighestBid($artwork_id) {
        $query = "SELECT MAX(bid_amount) as highest_bid FROM " . $this->table . " 
                  WHERE artwork_id = :artwork_id AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":artwork_id", $artwork_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['highest_bid'] ?? 0;
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function approveBid($bid_id) {
        // First, get the bid details
        $query = "SELECT * FROM " . $this->table . " WHERE id = :bid_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":bid_id", $bid_id);
        $stmt->execute();
        $bid = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$bid) {
            error_log("Bid not found: " . $bid_id);
            return false;
        }
        
        try {
            // Update the approved bid status
            $query = "UPDATE " . $this->table . " SET status = 'approved' WHERE id = :bid_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":bid_id", $bid_id);
            $stmt->execute();
            
            // Reject all other bids for this artwork
            $query = "UPDATE " . $this->table . " SET status = 'rejected' 
                      WHERE artwork_id = :artwork_id AND id != :bid_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $bid['artwork_id']);
            $stmt->bindParam(":bid_id", $bid_id);
            $stmt->execute();
            
            // Update artwork status to sold
            $query = "UPDATE artworks SET status = 'sold' WHERE id = :artwork_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $bid['artwork_id']);
            $stmt->execute();
            
            error_log("Bid approved successfully: " . $bid_id);
            return true;
        } catch (Exception $e) {
            error_log("Error approving bid: " . $e->getMessage());
            return false;
        }
    }
}
?>