<?php
require_once __DIR__ . '/../models/Artwork.php';
require_once __DIR__ . '/../models/Bid.php';

class ArtworkController {
    private $artworkModel;
    private $bidModel;

    public function __construct() {
        $this->artworkModel = new Artwork();
        $this->bidModel = new Bid();
    }

    public function showAddArtworkForm() {
        // Check if user is an artist
        if ($_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }
        include __DIR__ . '/../views/add-artwork.php';
    }

    public function addArtwork() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->showAddArtworkForm();
            return;
        }

        // Check if user is an artist
        if ($_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $initial_price = floatval($_POST['initial_price']);
        $artist_id = $_SESSION['user']['id'];

        // Validate inputs
        if (empty($title) || $initial_price <= 0) {
            $error = "Please provide a valid title and price.";
            include __DIR__ . '/../views/add-artwork.php';
            return;
        }

        // Handle file upload
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../uploads/artworks/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('artwork_') . '.' . $file_extension;
            $image_path = 'uploads/artworks/' . $filename;
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                $error = "Failed to upload image.";
                include __DIR__ . '/../views/add-artwork.php';
                return;
            }
        }

        if ($this->artworkModel->create($artist_id, $title, $description, $image_path, $initial_price)) {
            $success = "Artwork added successfully!";
            header("Location: index.php?action=my-artworks&success=" . urlencode($success));
            exit;
        } else {
            $error = "Failed to add artwork. Please try again.";
            include __DIR__ . '/../views/add-artwork.php';
        }
    }

    public function showMyArtworks() {
        // Check if user is an artist
        if ($_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        $artist_id = $_SESSION['user']['id'];
        $artworks = $this->artworkModel->findByArtistId($artist_id);
        
        // Get bids for each artwork
        foreach ($artworks as &$artwork) {
            $artwork['bids'] = $this->bidModel->findByArtworkId($artwork['id']);
        }

        include __DIR__ . '/../views/my-artworks.php';
    }

    public function showBrowseArtworks() {
        $artworks = $this->artworkModel->getAllAvailable();
        
        // Get highest bid for each artwork
        foreach ($artworks as &$artwork) {
            $artwork['highest_bid'] = $this->bidModel->getHighestBid($artwork['id']);
        }

        include __DIR__ . '/../views/browse-artworks.php';
    }

    public function approveBid() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?action=my-artworks");
            exit;
        }

        // Check if user is an artist
        if ($_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        $bid_id = intval($_POST['bid_id']);
        
        if ($this->bidModel->approveBid($bid_id)) {
            $success = "Bid approved successfully! The artwork has been sold.";
            header("Location: index.php?action=my-artworks&success=" . urlencode($success));
        } else {
            $error = "Failed to approve bid. Please try again.";
            header("Location: index.php?action=my-artworks&error=" . urlencode($error));
        }
        exit;
    }
}
?>