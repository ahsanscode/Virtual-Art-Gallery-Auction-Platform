<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Art Gallery & Auction Platform</title>
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
        
        .btn {
            padding: 0.5rem 1.5rem;
            border: 2px solid white;
            border-radius: 25px;
            background: transparent;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: white;
            color: #667eea;
        }
        
        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-role {
            background: rgba(255,255,255,0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-links {
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">🎨 VirtArt Gallery</a>
            <ul class="nav-links">
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="index.php">Dashboard</a></li>
                    <?php if ($_SESSION['user']['role'] === 'artist'): ?>
                        <li><a href="index.php?action=my-artworks">My Artworks</a></li>
                        <li><a href="index.php?action=add-artwork">Add Artwork</a></li>
                    <?php else: ?>
                        <li><a href="index.php?action=all-artworks">All Artworks</a></li>
                        <li><a href="index.php?action=browse">Browse Art</a></li>
                        <li><a href="index.php?action=auctions">Auctions</a></li>
                        <li><a href="index.php?action=favorites">Favorites</a></li>
                        <li><a href="index.php?action=purchase-history">Purchase History</a></li>
                    <?php endif; ?>
                    <li><a href="index.php?action=profile">Profile</a></li>
                    <li class="user-info">
                        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                        <span class="user-role"><?php echo ucfirst($_SESSION['user']['role']); ?></span>
                        <a href="index.php?action=logout" class="btn">Logout</a>
                    </li>
                <?php else: ?>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php?action=all-artworks">All Artworks</a></li>
                    <li><a href="index.php?action=browse">Browse Art</a></li>
                    <li><a href="index.php?action=about">About</a></li>
                    <li><a href="index.php?action=contact">Contact</a></li>
                    <li><a href="index.php?action=login" class="btn">Login</a></li>
                    <li><a href="index.php?action=signup" class="btn">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>