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
    
    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .artwork-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .artwork-card:hover {
        transform: translateY(-5px);
    }
    
    .artwork-image {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
        cursor: pointer;
    }
    
    .artwork-info {
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
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .artwork-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .artwork-price {
        color: #28a745;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }
    
    .artwork-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
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
    
    .btn-buy {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .btn-details {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    
    .artwork-meta {
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .quick-actions {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .quick-actions h3 {
        color: #333;
        margin-bottom: 1rem;
    }
    
    .action-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .action-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: transform 0.3s ease;
    }
    
    .action-link:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>🖼️ Browse Artworks</h1>
            <p>Discover amazing artworks from talented artists</p>
        </div>
        
        <div class="quick-actions">
            <h3>🎯 Quick Actions</h3>
            <div class="action-links">
                <a href="index.php?action=auctions" class="action-link">
                    🏆 Live Auctions
                </a>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer'): ?>
                    <a href="index.php?action=my-bids" class="action-link">
                        📊 My Bids
                    </a>
                    <a href="index.php?action=purchase-history" class="action-link">
                        📋 Purchase History
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (empty($artworks)): ?>
            <div class="empty-state">
                <h2>No artworks available</h2>
                <p>Check back soon for new artworks from our talented artists!</p>
                <a href="index.php?action=auctions" class="action-link">
                    🏆 Check Live Auctions
                </a>
            </div>
        <?php else: ?>
            <div class="artworks-grid">
                <?php foreach ($artworks as $artwork): ?>
                    <div class="artwork-card">
                        <div class="artwork-image" 
                             style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');"
                             onclick="location.href='index.php?action=artwork-details&id=<?php echo $artwork['id']; ?>'">
                        </div>
                        
                        <div class="artwork-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                            
                            <?php if ($artwork['description']): ?>
                                <div class="artwork-description"><?php echo htmlspecialchars($artwork['description']); ?></div>
                            <?php endif; ?>
                            
                            <div class="artwork-price">
                                $<?php echo number_format($artwork['starting_price'], 2); ?>
                            </div>
                            
                            <div class="artwork-meta">
                                Added: <?php echo date('M j, Y', strtotime($artwork['created_at'])); ?>
                            </div>
                            
                            <div class="artwork-actions">
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer'): ?>
                                    <form method="post" action="index.php?action=buy-artwork" style="flex: 1;">
                                        <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                                        <button type="submit" class="btn btn-buy" 
                                                onclick="return confirm('Purchase this artwork for $<?php echo number_format($artwork['starting_price'], 2); ?>?')">
                                            🛒 Buy Now
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <a href="index.php?action=artwork-details&id=<?php echo $artwork['id']; ?>" 
                                   class="btn btn-details">
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