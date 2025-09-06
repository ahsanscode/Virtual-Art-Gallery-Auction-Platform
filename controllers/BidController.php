<?php
require_once __DIR__ . '/../models/Bid.php';
require_once __DIR__ . '/../models/Artwork.php';

class BidController {
    private $bidModel;
    private $artworkModel;

    public function __construct() {
        $this->bidModel = new Bid();
        $this->artworkModel = new Artwork();
    }

    public function placeBid() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?action=browse");
            exit;
        }

        // Check if user is a buyer
        if ($_SESSION['user']['role'] !== 'buyer') {
            header("Location: index.php");
            exit;
        }

        $artwork_id = intval($_POST['artwork_id']);
        $bid_amount = floatval($_POST['bid_amount']);
        $buyer_id = $_SESSION['user']['id'];

        // Validate inputs
        if ($artwork_id <= 0 || $bid_amount <= 0) {
            $error = "Invalid artwork or bid amount.";
            header("Location: index.php?action=browse&error=" . urlencode($error));
            exit;
        }

        // Get artwork details
        $artwork = $this->artworkModel->findById($artwork_id);
        if (!$artwork || $artwork['status'] !== 'available') {
            $error = "Artwork is not available for bidding.";
            header("Location: index.php?action=browse&error=" . urlencode($error));
            exit;
        }

        // Check if bid is higher than current price
        $current_highest = $this->bidModel->getHighestBid($artwork_id);
        $minimum_bid = max($artwork['current_price'], $current_highest + 1);
        
        if ($bid_amount < $minimum_bid) {
            $error = "Bid must be at least $" . number_format($minimum_bid, 2);
            header("Location: index.php?action=browse&error=" . urlencode($error));
            exit;
        }

        // Place the bid
        if ($this->bidModel->create($artwork_id, $buyer_id, $bid_amount)) {
            // Update artwork's current price
            $this->artworkModel->updateCurrentPrice($artwork_id, $bid_amount);
            
            $success = "Bid placed successfully for $" . number_format($bid_amount, 2);
            header("Location: index.php?action=browse&success=" . urlencode($success));
        } else {
            $error = "Failed to place bid. Please try again.";
            header("Location: index.php?action=browse&error=" . urlencode($error));
        }
        exit;
    }

    public function showMyBids() {
        // Check if user is a buyer
        if ($_SESSION['user']['role'] !== 'buyer') {
            header("Location: index.php");
            exit;
        }

        $buyer_id = $_SESSION['user']['id'];
        $bids = $this->bidModel->findByBuyerId($buyer_id);

        include __DIR__ . '/../views/my-bids.php';
    }
}
?>