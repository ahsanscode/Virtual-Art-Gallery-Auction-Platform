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
    
    .bids-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .bid-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .bid-card:hover {
        transform: translateY(-5px);
    }
    
    .artwork-image {
        width: 100%;
        height: 150px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .bid-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-winning {
        background: #d4edda;
        color: #155724;
    }
    
    .status-outbid {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-ended {
        background: #f8d7da;
        color: #721c24;
    }
    
    .bid-info {
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
    
    .bid-details {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .bid-amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.5rem;
    }
    
    .bid-time {
        color: #666;
        font-size: 0.9rem;
    }
    
    .auction-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }
    
    .bid-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.2s ease;
        flex: 1;
        text-align: center;
        font-weight: 500;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-bid {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .empty-state h2 {
        color: #666;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: #999;
        margin-bottom: 2rem;
    }
    
    .quick-nav {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .nav-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .nav-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: transform 0.3s ease;
    }
    
    .nav-link:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>📊 My Bids</h1>
            <p>Track your bidding activity and auction participation</p>
        </div>
        
        <div class="quick-nav">
            <div class="nav-links">
                <a href="index.php?action=auctions" class="nav-link">
                    🏆 Live Auctions
                </a>
                <a href="index.php?action=browse" class="nav-link">
                    🖼️ Browse Artworks
                </a>
            </div>
        </div>
        
        <?php if (empty($bids)): ?>
            <div class="empty-state">
                <h2>No bids placed yet</h2>
                <p>Start participating in auctions by placing your first bid!</p>
                <a href="index.php?action=auctions" class="nav-link">
                    🏆 View Live Auctions
                </a>
            </div>
        <?php else: ?>
            <div class="bids-grid">
                <?php foreach ($bids as $bid): ?>
                    <?php
                        // Determine bid status - this would need to be enhanced with real-time data
                        $status = 'ended'; // Default status
                        $status_text = 'Auction Ended';
                        $status_class = 'status-ended';
                    ?>
                    <div class="bid-card">
                        <div class="artwork-image" style="background-image: url('<?php echo htmlspecialchars($bid['image_url']); ?>');">
                            <span class="bid-status <?php echo $status_class; ?>">
                                <?php echo $status_text; ?>
                            </span>
                        </div>
                        
                        <div class="bid-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($bid['artwork_title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($bid['artist_name']); ?></div>
                            
                            <div class="bid-details">
                                <div class="bid-amount">
                                    Your Bid: $<?php echo number_format($bid['bid_amount'], 2); ?>
                                </div>
                                <div class="bid-time">
                                    Placed: <?php echo date('M j, Y g:i A', strtotime($bid['bid_time'])); ?>
                                </div>
                            </div>
                            
                            <div class="bid-actions">
                                <a href="index.php?action=auction-details&id=<?php echo $bid['artwork_id']; ?>" 
                                   class="btn btn-view">
                                    👁️ View Auction
                                </a>
                                
                                <?php if ($status !== 'ended'): ?>
                                    <a href="index.php?action=auction-details&id=<?php echo $bid['artwork_id']; ?>" 
                                       class="btn btn-bid">
                                        💰 Bid Again
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>