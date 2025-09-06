<?php
require_once __DIR__ . '/../../config/Database.php';

class Bid {
    private $conn;
    private $table = "bids";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($artwork_id, $bidder_id, $bid_amount) {
        try {
            $query = "INSERT INTO " . $this->table . " (artwork_id, bidder_id, bid_amount) 
                      VALUES (:artwork_id, :bidder_id, :bid_amount)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->bindParam(":bidder_id", $bidder_id);
            $stmt->bindParam(":bid_amount", $bid_amount);
            return $stmt->execute();
        } catch(PDOException $exception) {
            // Return false if table doesn't exist or other DB error
            return false;
        }
    }

    public function findByArtwork($artwork_id) {
        try {
            $query = "SELECT b.*, u.name as bidder_name FROM " . $this->table . " b 
                      LEFT JOIN users u ON b.bidder_id = u.id 
                      WHERE b.artwork_id = :artwork_id 
                      ORDER BY b.bid_amount DESC, b.bid_time DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            // Return empty array if table doesn't exist or other DB error
            return [];
        }
    }

    public function findByBidder($bidder_id) {
        try {
            $query = "SELECT b.*, a.title as artwork_title, a.image_url, u.name as artist_name 
                      FROM " . $this->table . " b 
                      LEFT JOIN artworks a ON b.artwork_id = a.id 
                      LEFT JOIN users u ON a.artist_id = u.id 
                      WHERE b.bidder_id = :bidder_id 
                      ORDER BY b.bid_time DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":bidder_id", $bidder_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            // Return empty array if table doesn't exist or other DB error
            return [];
        }
    }

    public function getHighestBid($artwork_id) {
        try {
            $query = "SELECT MAX(bid_amount) as highest_bid FROM " . $this->table . " 
                      WHERE artwork_id = :artwork_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['highest_bid'] ?? 0;
        } catch(PDOException $exception) {
            // Return 0 if table doesn't exist or other DB error
            return 0;
        }
    }

    public function getHighestBidder($artwork_id) {
        try {
            $query = "SELECT b.*, u.name as bidder_name FROM " . $this->table . " b 
                      LEFT JOIN users u ON b.bidder_id = u.id 
                      WHERE b.artwork_id = :artwork_id 
                      ORDER BY b.bid_amount DESC, b.bid_time DESC 
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            // Return false if table doesn't exist or other DB error
            return false;
        }
    }

    public function getBidCount($artwork_id) {
        try {
            $query = "SELECT COUNT(*) as bid_count FROM " . $this->table . " 
                      WHERE artwork_id = :artwork_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['bid_count'] ?? 0;
        } catch(PDOException $exception) {
            // Return 0 if table doesn't exist or other DB error
            return 0;
        }
    }

    public function hasUserBid($artwork_id, $bidder_id) {
        try {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                      WHERE artwork_id = :artwork_id AND bidder_id = :bidder_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->bindParam(":bidder_id", $bidder_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch(PDOException $exception) {
            // Return false if table doesn't exist or other DB error
            return false;
        }
    }

    public function getUserHighestBid($artwork_id, $bidder_id) {
        try {
            $query = "SELECT MAX(bid_amount) as highest_bid FROM " . $this->table . " 
                      WHERE artwork_id = :artwork_id AND bidder_id = :bidder_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":artwork_id", $artwork_id);
            $stmt->bindParam(":bidder_id", $bidder_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['highest_bid'] ?? 0;
        } catch(PDOException $exception) {
            // Return 0 if table doesn't exist or other DB error
            return 0;
        }
    }
}
?>