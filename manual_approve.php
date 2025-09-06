<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    // Approve the bid
    $query = "UPDATE bids SET status = 'approved' WHERE id = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Update artwork status to sold
    $query = "UPDATE artworks SET status = 'sold' WHERE id = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    echo "Bid approved successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>