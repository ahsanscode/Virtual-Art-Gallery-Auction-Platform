<?php
session_start();

require_once __DIR__ . '/controllers/AuthController.php';

$action = $_GET['action'] ?? null;
$auth = new AuthController();

if ($action === 'logout') {
    $auth->logout();
    exit;
}

// If not logged in, show login/signup
if (!isset($_SESSION['user'])) {
    if ($action === 'signup') {
        $auth->signup();
    } else {
        $auth->login();
    }
    exit;
}

// If logged in, show welcome and logout
include __DIR__ . '/views/welcome.php';