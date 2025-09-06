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
$artwork = new ArtworkController();
$bid = new BidController();

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
        // Show browse page for guests
        $artwork->showBrowseArtworks();
    } elseif ($action === 'all-artworks') {
        // Show all artworks page for guests
        $artwork->showAllArtworks();
    } elseif ($action === 'auctions') {
        // Show auctions page for guests  
        $bid->showAuctions();
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
            $artwork->showMyArtworks();
        } else {
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'add-artwork':
        if ($userRole === 'artist') {
            $artwork->addArtwork();
        } else {
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'start-auction':
        if ($userRole === 'artist') {
            $artwork->startAuction();
        } else {
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'delete-artwork':
        if ($userRole === 'artist') {
            $artwork->deleteArtwork();
        } else {
            include __DIR__ . '/views/buyer-dashboard.php';
        }
        break;
        
    case 'end-auction':
        if ($userRole === 'artist') {
            $bid->endAuction();
        } else {
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
        $artwork->showBrowseArtworks();
        break;
        
    case 'all-artworks':
        $artwork->showAllArtworks();
        break;
        
    case 'artwork-details':
        $artwork->showArtworkDetails();
        break;
        
    case 'buy-artwork':
        if ($userRole === 'buyer') {
            $artwork->buyArtwork();
        } else {
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    case 'purchase-success':
        if ($userRole === 'buyer') {
            $artwork->showPurchaseSuccess();
        } else {
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    case 'auctions':
        $bid->showAuctions();
        break;
        
    case 'auction-details':
        $bid->showAuctionDetails();
        break;
        
    case 'place-bid':
        if ($userRole === 'buyer') {
            $bid->placeBid();
        } else {
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    case 'my-bids':
        if ($userRole === 'buyer') {
            $bid->showMyBids();
        } else {
            include __DIR__ . '/views/artist-dashboard.php';
        }
        break;
        
    case 'favorites':
    case 'purchase-history':
        if ($userRole === 'buyer') {
            if ($action === 'purchase-history') {
                $bid->showPurchaseHistory();
            } else {
                // For now, redirect to buyer dashboard  
                // favorites could be implemented as separate pages later
                include __DIR__ . '/views/buyer-dashboard.php';
            }
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