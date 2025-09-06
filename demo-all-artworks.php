<?php
// Simple demo page to show the all-artworks functionality without database
$mock_artworks = [
    [
        'id' => 1,
        'title' => 'Abstract Sunset',
        'artist_name' => 'John Doe',
        'description' => 'A beautiful abstract painting capturing the essence of a vibrant sunset',
        'image_url' => 'https://via.placeholder.com/300x200/FF6B6B/FFFFFF?text=Abstract+Sunset',
        'starting_price' => 250.00,
        'status' => 'available',
        'created_at' => '2024-01-15 10:00:00'
    ],
    [
        'id' => 2,
        'title' => 'Ocean Waves',
        'artist_name' => 'Jane Smith',
        'description' => 'Dynamic ocean waves captured in motion with brilliant blues and whites',
        'image_url' => 'https://via.placeholder.com/300x200/4ECDC4/FFFFFF?text=Ocean+Waves',
        'starting_price' => 450.00,
        'status' => 'in_auction',
        'auction_end_time' => '2024-12-25 18:00:00',
        'highest_bid' => 500.00,
        'bid_count' => 3,
        'current_bid' => 500.00,
        'created_at' => '2024-01-10 14:30:00'
    ],
    [
        'id' => 3,
        'title' => 'Mountain Landscape',
        'artist_name' => 'Bob Wilson',
        'description' => 'Serene mountain landscape with snow-capped peaks and alpine meadows',
        'image_url' => 'https://via.placeholder.com/300x200/45B7D1/FFFFFF?text=Mountain+View',
        'starting_price' => 300.00,
        'status' => 'available',
        'created_at' => '2024-01-20 09:15:00'
    ],
    [
        'id' => 4,
        'title' => 'City Lights',
        'artist_name' => 'Alice Brown',
        'description' => 'Urban nightscape with dazzling city lights and reflections',
        'image_url' => 'https://via.placeholder.com/300x200/9B59B6/FFFFFF?text=City+Lights',
        'starting_price' => 375.00,
        'status' => 'in_auction',
        'auction_end_time' => '2024-12-30 20:00:00',
        'highest_bid' => 425.00,
        'bid_count' => 7,
        'current_bid' => 425.00,
        'created_at' => '2024-01-12 16:45:00'
    ]
];

// Apply search filter if provided
$search_term = $_GET['search'] ?? '';
if (!empty($search_term)) {
    $artworks = array_filter($mock_artworks, function($artwork) use ($search_term) {
        return stripos($artwork['title'], $search_term) !== false;
    });
} else {
    $artworks = $mock_artworks;
}

// Mock session for demo
$_SESSION = ['user' => ['role' => 'buyer']];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Artworks & Auctions - Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #f0f0f0;
        }
        
        .nav-links .active {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">🎨 VirtArt Gallery</a>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#" class="active">All Artworks</a></li>
                <li><a href="#">Browse Art</a></li>
                <li><a href="#">Auctions</a></li>
                <li><a href="#">My Bids</a></li>
            </ul>
        </div>
    </nav>

<?php
// Include the actual all-artworks view content with the mock data
include 'views/all-artworks.php';
?>

</body>
</html>