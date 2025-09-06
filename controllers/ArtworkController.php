<?php
require_once __DIR__ . '/../models/artwork/Artwork.php';
require_once __DIR__ . '/../models/user/User.php';

class ArtworkController {
    private $artworkModel;
    private $userModel;

    public function __construct() {
        $this->artworkModel = new Artwork();
        $this->userModel = new User();
    }

    public function showAddArtwork() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }
        
        include __DIR__ . '/../views/add-artwork.php';
    }

    public function addArtwork() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $starting_price = floatval($_POST['starting_price']);
            
            // Handle file upload
            $upload_dir = __DIR__ . '/../uploads/artworks/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $error = '';
            $success = '';
            $image_url = '';

            // Validate input
            if (empty($title) || empty($starting_price) || $starting_price <= 0) {
                $error = "Title and valid starting price are required.";
            } elseif (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $max_size = 5 * 1024 * 1024; // 5MB

                if (!in_array($_FILES['image']['type'], $allowed_types)) {
                    $error = "Only JPEG, PNG, and GIF images are allowed.";
                } elseif ($_FILES['image']['size'] > $max_size) {
                    $error = "File size must be less than 5MB.";
                } else {
                    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $file_name = uniqid() . '.' . $file_extension;
                    $file_path = $upload_dir . $file_name;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
                        $image_url = 'uploads/artworks/' . $file_name;
                    } else {
                        $error = "Failed to upload image.";
                    }
                }
            } else {
                $error = "Please select an image to upload.";
            }

            if (empty($error)) {
                if ($this->artworkModel->create($_SESSION['user']['id'], $title, $description, $image_url, $starting_price)) {
                    $success = "Artwork added successfully!";
                } else {
                    $error = "Failed to add artwork. Please try again.";
                }
            }

            include __DIR__ . '/../views/add-artwork.php';
        } else {
            $this->showAddArtwork();
        }
    }

    public function showMyArtworks() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        $artworks = $this->artworkModel->findByArtist($_SESSION['user']['id']);
        include __DIR__ . '/../views/my-artworks.php';
    }

    public function showBrowseArtworks() {
        $artworks = $this->artworkModel->findAvailable();
        include __DIR__ . '/../views/browse-artworks.php';
    }

    public function showArtworkDetails() {
        $artwork_id = $_GET['id'] ?? null;
        
        if (!$artwork_id) {
            header("Location: index.php?action=browse");
            exit;
        }

        $artwork = $this->artworkModel->findById($artwork_id);
        
        if (!$artwork) {
            header("Location: index.php?action=browse");
            exit;
        }

        include __DIR__ . '/../views/artwork-details.php';
    }

    public function buyArtwork() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'buyer') {
            header("Location: index.php?action=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $artwork_id = $_POST['artwork_id'] ?? null;
            
            if ($artwork_id) {
                $artwork = $this->artworkModel->findById($artwork_id);
                
                if ($artwork && $artwork['status'] === 'available') {
                    // Mark as sold and set buyer
                    if ($this->artworkModel->markAsSold($artwork_id, $_SESSION['user']['id'], $artwork['starting_price'])) {
                        header("Location: index.php?action=purchase-success&id=" . $artwork_id);
                        exit;
                    }
                }
            }
        }
        
        header("Location: index.php?action=browse");
        exit;
    }

    public function showPurchaseSuccess() {
        $artwork_id = $_GET['id'] ?? null;
        
        if (!$artwork_id) {
            header("Location: index.php?action=browse");
            exit;
        }

        $artwork = $this->artworkModel->findById($artwork_id);
        include __DIR__ . '/../views/purchase-success.php';
    }

    public function startAuction() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $artwork_id = $_POST['artwork_id'] ?? null;
            
            if ($artwork_id) {
                $artwork = $this->artworkModel->findById($artwork_id);
                
                if ($artwork && $artwork['artist_id'] == $_SESSION['user']['id'] && $artwork['status'] === 'available') {
                    $this->artworkModel->startAuction($artwork_id);
                }
            }
        }
        
        header("Location: index.php?action=my-artworks");
        exit;
    }

    public function deleteArtwork() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'artist') {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $artwork_id = $_POST['artwork_id'] ?? null;
            
            if ($artwork_id) {
                $artwork = $this->artworkModel->findById($artwork_id);
                
                if ($artwork && $artwork['artist_id'] == $_SESSION['user']['id'] && $artwork['status'] === 'available') {
                    // Delete image file
                    if ($artwork['image_url'] && file_exists(__DIR__ . '/../' . $artwork['image_url'])) {
                        unlink(__DIR__ . '/../' . $artwork['image_url']);
                    }
                    
                    $this->artworkModel->delete($artwork_id);
                }
            }
        }
        
        header("Location: index.php?action=my-artworks");
        exit;
    }
}
?>