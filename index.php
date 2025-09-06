<?php
session_start();

// Use proper authentication controller
require_once __DIR__ . '/controllers/authentication/AuthController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/ArtworkController.php';
require_once __DIR__ . '/controllers/BidController.php';

$action = $_GET['action'] ?? null;
$auth = new AuthController();
$profile = new ProfileController();
$artworkController = new ArtworkController();
$bidController = new BidController();

if ($action === 'logout') {
    $auth->logout();
    exit;
}

// If not logged in, show appropriate pages
if (!isset($_SESSION['user'])) {
    if ($action === 'signup') {
        $auth->signup();
    } elseif ($action === 'login') {
        $auth->login();
    } elseif ($action === 'browse') {
        // Show browse page for guests (could be implemented later)
        include __DIR__ . '/views/home.php';
    } elseif ($action === 'about') {
        // Show about page (could be implemented later)
        include __DIR__ . '/views/home.php';
    } elseif ($action === 'contact') {
        // Show contact page (could be implemented later)
        include __DIR__ . '/views/home.php';
    } else {
        // Show home page for non-logged users
        include __DIR__ . '/views/home.php';
    }
    exit;
}

// If logged in, show role-specific dashboards and pages
$userRole = $_SESSION['user']['role'];

switch ($action) {
    case 'profile':
        $profile->showProfile();
        break;
        
    case 'update-profile':
        $profile->updateProfile();
        break;
        
    case 'delete-profile':
        $profile->deleteProfile();
        break;
        
    case 'my-artworks':
        if ($userRole === 'artist') {
            $artworkController->showMyArtworks();
        } else {
            // Redirect buyers to their dashboard
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'add-artwork':
        if ($userRole === 'artist') {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $artworkController->addArtwork();
            } else {
                $artworkController->showAddArtworkForm();
            }
        } else {
            // Redirect buyers to their dashboard
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'approve-bid':
        if ($userRole === 'artist') {
            $artworkController->approveBid();
        } else {
            // Redirect buyers to their dashboard
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'sales-report':
    case 'profile-settings':
        if ($userRole === 'artist') {
            // For now, redirect to artist dashboard
            // These could be implemented as separate pages later
            include __DIR__ . '/views/artist-dashboard.php';
        } else {
            // Redirect buyers to their dashboard
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'browse':
        $artworkController->showBrowseArtworks();
        break;
        
    case 'place-bid':
        if ($userRole === 'buyer') {
            $bidController->placeBid();
        } else {
            // Redirect artists to their dashboard
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    case 'my-bids':
        if ($userRole === 'buyer') {
            $bidController->showMyBids();
        } else {
            // Redirect artists to their dashboard
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    case 'auctions':
    case 'favorites':
    case 'purchase-history':
        if ($userRole === 'buyer') {
            // For now, redirect to buyer dashboard
            // These could be implemented as separate pages later
            include __DIR__ . '/views/buyer-dashboard.php';
        } else {
            // Redirect artists to their dashboard
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    default:
        // Show role-specific dashboard
        if ($userRole === 'artist') {
            include __DIR__ . '/views/artist-dashboard.php';
        } else {
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
}