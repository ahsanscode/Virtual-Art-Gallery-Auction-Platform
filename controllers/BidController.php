<?php
require_once __DIR__ . '/../models/bid/Bid.php';
require_once __DIR__ . '/../models/artwork/Artwork.php';

class BidController {
    private $bidModel;
    private $artworkModel;

    public function __construct() {
        $this->bidModel = new Bid();
        $this->artworkModel = new Artwork();
    }

    public function showAuctions() {
        $artworks = $this->artworkModel->findInAuction();
        
        // Add bid information for each artwork
        foreach ($artworks as &$artwork) {
            $artwork['highest_bid'] = $this->bidModel->getHighestBid($artwork['id']);
            $artwork['bid_count'] = $this->bidModel->getBidCount($artwork['id']);
            $artwork['current_bid'] = max($artwork['highest_bid'], $artwork['starting_price']);
            
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer') {
                $artwork['user_has_bid'] = $this->bidModel->hasUserBid($artwork['id'], $_SESSION['user']['id']);
                $artwork['user_highest_bid'] = $this->bidModel->getUserHighestBid($artwork['id'], $_SESSION['user']['id']);
            }
        }
        
        include __DIR__ . '/../views/auctions.php';
    }

    public function showAuctionDetails() {
        $artwork_id = $_GET['id'] ?? null;
        
        if (!$artwork_id) {
            header("Location: index.php?action=auctions");
            exit;
        }

        $artwork = $this->artworkModel->findById($artwork_id);
        
        if (!$artwork || $artwork['status'] !== 'in_auction') {
            header("Location: index.php?action=auctions");
            exit;
        }

        // Get bid information
        $bids = $this->bidModel->findByArtwork($artwork_id);
        $highest_bid = $this->bidModel->getHighestBid($artwork_id);
        $bid_count = $this->bidModel->getBidCount($artwork_id);
        $current_bid = max($highest_bid, $artwork['starting_price']);
        
        // Update current bid in artwork
        if ($highest_bid > 0) {
            $this->artworkModel->updateCurrentBid($artwork_id, $highest_bid);
        }

        include __DIR__ . '/../views/auction-details.php';
    }

    public function placeBid() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'buyer') {
            header("Location: index.php?action=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $artwork_id = $_POST['artwork_id'] ?? null;
            $bid_amount = floatval($_POST['bid_amount'] ?? 0);
            
            $error = '';
            $success = '';

            if (!$artwork_id || $bid_amount <= 0) {
                $error = "Invalid bid information.";
            } else {
                $artwork = $this->artworkModel->findById($artwork_id);
                
                if (!$artwork || $artwork['status'] !== 'in_auction') {
                    $error = "Artwork is not available for auction.";
                } elseif (strtotime($artwork['auction_end_time']) <= time()) {
                    $error = "Auction has ended.";
                } else {
                    $current_highest = $this->bidModel->getHighestBid($artwork_id);
                    $minimum_bid = max($current_highest, $artwork['starting_price']) + 1;
                    
                    if ($bid_amount < $minimum_bid) {
                        $error = "Bid must be at least $" . number_format($minimum_bid, 2);
                    } else {
                        // Place the bid
                        if ($this->bidModel->create($artwork_id, $_SESSION['user']['id'], $bid_amount)) {
                            // Update current bid in artwork
                            $this->artworkModel->updateCurrentBid($artwork_id, $bid_amount);
                            $success = "Bid placed successfully!";
                        } else {
                            $error = "Failed to place bid. Please try again.";
                        }
                    }
                }
            }

            // Return to auction details with message
            if ($error) {
                $_SESSION['bid_error'] = $error;
            }
            if ($success) {
                $_SESSION['bid_success'] = $success;
            }
            
            header("Location: index.php?action=auction-details&id=" . $artwork_id);
            exit;
        }
        
        header("Location: index.php?action=auctions");
        exit;
    }

    public function showMyBids() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'buyer') {
            header("Location: index.php");
            exit;
        }

        $bids = $this->bidModel->findByBidder($_SESSION['user']['id']);
        include __DIR__ . '/../views/my-bids.php';
    }

    public function showPurchaseHistory() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'buyer') {
            header("Location: index.php");
            exit;
        }

        $purchases = $this->artworkModel->findByBuyer($_SESSION['user']['id']);
        include __DIR__ . '/../views/purchase-history.php';
    }

    public function endAuction() {
        // This would be called by a cron job or scheduled task
        // For now, we'll manually handle auction ending
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $artwork_id = $_POST['artwork_id'] ?? null;
            
            if ($artwork_id) {
                $artwork = $this->artworkModel->findById($artwork_id);
                
                if ($artwork && $artwork['artist_id'] == $_SESSION['user']['id'] && $artwork['status'] === 'in_auction') {
                    $highest_bidder = $this->bidModel->getHighestBidder($artwork_id);
                    
                    if ($highest_bidder) {
                        // Mark as sold to highest bidder
                        $this->artworkModel->markAsSold($artwork_id, $highest_bidder['bidder_id'], $highest_bidder['bid_amount']);
                    } else {
                        // No bids, change back to available
                        $this->artworkModel->updateStatus($artwork_id, 'available');
                    }
                }
            }
        }
        
        header("Location: index.php?action=my-artworks");
        exit;
    }
}
?>