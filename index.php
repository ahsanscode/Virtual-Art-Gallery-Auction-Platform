<?php
session_start();

// Use proper authentication controller
require_once __DIR__ . '/controllers/AuthController.php';

$action = $_GET['action'] ?? null;
$auth = new AuthController();

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
    case 'my-artworks':
    case 'add-artwork':
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