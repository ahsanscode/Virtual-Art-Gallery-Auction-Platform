<?php include 'header.php'; ?>

<style>
    .main-content {
        min-height: calc(100vh - 140px);
        padding: 2rem;
        background: #f8f9fa;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .page-header {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .page-header h1 {
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .page-header p {
        color: #666;
        font-size: 1.1rem;
    }
    
    .purchases-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .purchase-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .purchase-card:hover {
        transform: translateY(-5px);
    }
    
    .artwork-image {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .purchase-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        background: #28a745;
        color: white;
    }
    
    .purchase-info {
        padding: 1.5rem;
    }
    
    .artwork-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .artwork-artist {
        color: #667eea;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }
    
    .purchase-details {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .purchase-amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.5rem;
    }
    
    .purchase-date {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .purchase-type {
        font-size: 0.85rem;
        color: #495057;
        font-weight: 500;
    }
    
    .purchase-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.9rem;
        text-align: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }
    
    .btn-view {
        background: #667eea;
        color: white;
        flex: 1;
    }
    
    .btn-view:hover {
        background: #5a6fd8;
        color: white;
        text-decoration: none;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .empty-state h2 {
        color: #333;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: #666;
        margin-bottom: 2rem;
    }
    
    .nav-link {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    
    .nav-link:hover {
        background: #5a6fd8;
        color: white;
        text-decoration: none;
    }
    
    .quick-nav {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .nav-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>🛍️ Purchase History</h1>
            <p>View all your purchased artworks and auction wins</p>
        </div>
        
        <div class="quick-nav">
            <div class="nav-links">
                <a href="index.php?action=browse" class="nav-link">
                    🖼️ Browse Artworks
                </a>
                <a href="index.php?action=auctions" class="nav-link">
                    🏆 Live Auctions
                </a>
                <a href="index.php?action=my-bids" class="nav-link">
                    📊 My Bids
                </a>
                <a href="index.php" class="nav-link">
                    🏠 Dashboard
                </a>
            </div>
        </div>
        
        <?php if (empty($purchases)): ?>
            <div class="empty-state">
                <h2>No purchases yet</h2>
                <p>You haven't purchased any artworks or won any auctions yet. Start browsing to find something you love!</p>
                <a href="index.php?action=browse" class="nav-link">
                    🖼️ Browse Artworks
                </a>
                <a href="index.php?action=auctions" class="nav-link">
                    🏆 View Live Auctions
                </a>
            </div>
        <?php else: ?>
            <div class="purchases-grid">
                <?php foreach ($purchases as $purchase): ?>
                    <div class="purchase-card">
                        <div class="artwork-image" style="background-image: url('<?php echo htmlspecialchars($purchase['image_url']); ?>');">
                            <span class="purchase-status">
                                ✅ Purchased
                            </span>
                        </div>
                        
                        <div class="purchase-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($purchase['title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($purchase['artist_name']); ?></div>
                            
                            <div class="purchase-details">
                                <div class="purchase-amount">
                                    $<?php echo number_format($purchase['final_sale_price'], 2); ?>
                                </div>
                                <div class="purchase-date">
                                    Purchased: <?php echo date('M j, Y g:i A', strtotime($purchase['updated_at'])); ?>
                                </div>
                                <div class="purchase-type">
                                    <?php
                                    // Check if this was from an auction by checking if current_bid exists
                                    if ($purchase['current_bid'] && $purchase['current_bid'] > 0) {
                                        echo '🏆 Won through auction';
                                    } else {
                                        echo '🛒 Direct purchase';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="purchase-actions">
                                <a href="index.php?action=artwork-details&id=<?php echo $purchase['id']; ?>" 
                                   class="btn btn-view">
                                    👁️ View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>