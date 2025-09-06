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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .page-title h1 {
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .page-title p {
        color: #666;
        font-size: 1.1rem;
    }
    
    .add-artwork-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: transform 0.3s ease;
    }
    
    .add-artwork-btn:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
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
    }
    
    .artwork-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: capitalize;
    }
    
    .status-available {
        background: #d4edda;
        color: #155724;
    }
    
    .status-in_auction {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-sold {
        background: #f8d7da;
        color: #721c24;
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
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .artwork-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
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
    }
    
    .btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }
    
    .btn-auction {
        background: #ffc107;
        color: #212529;
    }
    
    .btn-delete {
        background: #dc3545;
        color: white;
    }
    
    .btn-end-auction {
        background: #17a2b8;
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
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <div class="page-title">
                <h1>🎨 My Artworks</h1>
                <p>Manage your creative portfolio</p>
            </div>
            <a href="index.php?action=add-artwork" class="add-artwork-btn">
                ➕ Add New Artwork
            </a>
        </div>
        
        <?php if (empty($artworks)): ?>
            <div class="empty-state">
                <h2>No artworks yet</h2>
                <p>Start building your portfolio by adding your first artwork!</p>
                <a href="index.php?action=add-artwork" class="add-artwork-btn">
                    ✨ Add Your First Artwork
                </a>
            </div>
        <?php else: ?>
            <div class="artworks-grid">
                <?php foreach ($artworks as $artwork): ?>
                    <div class="artwork-card">
                        <div class="artwork-image" style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');">
                            <span class="artwork-status status-<?php echo $artwork['status']; ?>">
                                <?php echo str_replace('_', ' ', $artwork['status']); ?>
                            </span>
                        </div>
                        
                        <div class="artwork-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                            
                            <?php if ($artwork['description']): ?>
                                <div class="artwork-description"><?php echo htmlspecialchars($artwork['description']); ?></div>
                            <?php endif; ?>
                            
                            <div class="artwork-price">
                                Starting: $<?php echo number_format($artwork['starting_price'], 2); ?>
                                <?php if ($artwork['current_bid']): ?>
                                    <br><small>Current bid: $<?php echo number_format($artwork['current_bid'], 2); ?></small>
                                <?php endif; ?>
                                <?php if ($artwork['final_sale_price']): ?>
                                    <br><small>Sold for: $<?php echo number_format($artwork['final_sale_price'], 2); ?></small>
                                <?php endif; ?>
                            </div>
                            
                            <div class="artwork-meta">
                                Created: <?php echo date('M j, Y', strtotime($artwork['created_at'])); ?>
                                <?php if ($artwork['status'] === 'in_auction'): ?>
                                    <br>Auction ends: <?php echo date('M j, Y g:i A', strtotime($artwork['auction_end_time'])); ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="artwork-actions">
                                <?php if ($artwork['status'] === 'available'): ?>
                                    <form method="post" action="index.php?action=start-auction" style="flex: 1;">
                                        <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                                        <button type="submit" class="btn btn-auction" onclick="return confirm('Start auction for this artwork?')">
                                            🏆 Start Auction
                                        </button>
                                    </form>
                                    
                                    <form method="post" action="index.php?action=delete-artwork" style="flex: 1;">
                                        <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this artwork?')">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                <?php elseif ($artwork['status'] === 'in_auction'): ?>
                                    <?php if (strtotime($artwork['auction_end_time']) <= time()): ?>
                                        <form method="post" action="index.php?action=end-auction" style="flex: 1;">
                                            <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                                            <button type="submit" class="btn btn-end-auction">
                                                🏁 End Auction
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="btn" style="background: #6c757d; color: white; cursor: default;">
                                            ⏱️ Auction Active
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="btn" style="background: #28a745; color: white; cursor: default;">
                                        ✅ Sold
                                    </span>
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