<?php include 'header.php'; ?>
<style>
    .main-content {
        min-height: calc(100vh - 140px);
        padding: 2rem;
        background: #f8f9fa;
    }
    
    .container {
        max-width: 1000px;
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
    
    .page-title {
        color: #333;
        margin: 0 0 0.5rem 0;
    }
    
    .page-subtitle {
        color: #666;
        margin: 0;
    }
    
    .bids-list {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .bid-item {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid #f5f5f5;
        transition: background-color 0.2s ease;
    }
    
    .bid-item:last-child {
        border-bottom: none;
    }
    
    .bid-item:hover {
        background-color: #f8f9fa;
    }
    
    .artwork-image {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }
    
    .artwork-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .bid-info {
        flex: 1;
        min-width: 0;
    }
    
    .artwork-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .artwork-artist {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .bid-details {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .bid-amount {
        font-weight: 600;
        color: #333;
    }
    
    .bid-date {
        color: #666;
        font-size: 0.9rem;
    }
    
    .bid-status {
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
        text-transform: uppercase;
        margin-left: 1rem;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .status-approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .status-rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .no-bids {
        text-align: center;
        padding: 3rem;
        color: #666;
    }
    
    .browse-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
    
    .browse-link:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .bid-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .artwork-image {
            margin-right: 0;
            margin-bottom: 1rem;
        }
        
        .bid-status {
            margin-left: 0;
            margin-top: 0.5rem;
        }
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">My Bids</h1>
            <p class="page-subtitle">Track your bidding activity and status</p>
        </div>
        
        <?php if (empty($bids)): ?>
            <div class="no-bids">
                <h3>No bids yet</h3>
                <p>You haven't placed any bids yet. Start exploring artworks and place your first bid!</p>
                <a href="index.php?action=browse" class="browse-link">Browse Artworks</a>
            </div>
        <?php else: ?>
            <div class="bids-list">
                <?php foreach ($bids as $bid): ?>
                    <div class="bid-item">
                        <div class="artwork-image">
                            <?php if ($bid['image_path']): ?>
                                <img src="<?php echo htmlspecialchars($bid['image_path']); ?>" alt="<?php echo htmlspecialchars($bid['artwork_title']); ?>">
                            <?php else: ?>
                                🎨
                            <?php endif; ?>
                        </div>
                        
                        <div class="bid-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($bid['artwork_title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($bid['artist_name']); ?></div>
                            <div class="bid-details">
                                <div class="bid-amount">Bid: $<?php echo number_format($bid['bid_amount'], 2); ?></div>
                                <div class="bid-date"><?php echo date('M j, Y g:i A', strtotime($bid['created_at'])); ?></div>
                            </div>
                        </div>
                        
                        <div class="bid-status status-<?php echo $bid['status']; ?>">
                            <?php echo ucfirst($bid['status']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>