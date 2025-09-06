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
    
    .back-link {
        color: #667eea;
        text-decoration: none;
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
    
    .artwork-header {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
    
    .artwork-image {
        width: 100%;
        height: 500px;
        background-size: cover;
        background-position: center;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .artwork-info h1 {
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 2.5rem;
    }
    
    .artist-name {
        color: #667eea;
        font-size: 1.3rem;
        margin-bottom: 2rem;
        font-weight: 500;
    }
    
    .artwork-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }
    
    .artwork-status {
        background: #d4edda;
        color: #155724;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-block;
        margin-bottom: 2rem;
    }
    
    .status-in_auction {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-sold {
        background: #f8d7da;
        color: #721c24;
    }
    
    .price-section {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .price-label {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    
    .price-amount {
        font-size: 3rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .artwork-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    
    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.2s ease;
        font-weight: 600;
        min-width: 150px;
        text-align: center;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .btn-buy {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .btn-auction {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
    }
    
    .btn-disabled {
        background: #6c757d;
        color: white;
        cursor: not-allowed;
        transform: none;
    }
    
    .artwork-meta {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .meta-item {
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .meta-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .meta-value {
        color: #333;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .artwork-header {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .artwork-info h1 {
            font-size: 2rem;
        }
        
        .price-amount {
            font-size: 2rem;
        }
        
        .artwork-actions {
            flex-direction: column;
            align-items: center;
        }
        
        .btn {
            width: 100%;
            max-width: 300px;
        }
    }
</style>

<div class="main-content">
    <div class="container">
        <a href="index.php?action=browse" class="back-link">← Back to Browse</a>
        
        <div class="artwork-header">
            <div class="artwork-image" style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');"></div>
            
            <div class="artwork-info">
                <h1><?php echo htmlspecialchars($artwork['title']); ?></h1>
                <div class="artist-name">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                
                <div class="artwork-status status-<?php echo $artwork['status']; ?>">
                    <?php echo str_replace('_', ' ', $artwork['status']); ?>
                </div>
                
                <?php if ($artwork['description']): ?>
                    <div class="artwork-description">
                        <?php echo nl2br(htmlspecialchars($artwork['description'])); ?>
                    </div>
                <?php endif; ?>
                
                <div class="price-section">
                    <?php if ($artwork['status'] === 'available'): ?>
                        <div class="price-label">Purchase Price</div>
                        <div class="price-amount">$<?php echo number_format($artwork['starting_price'], 2); ?></div>
                        
                        <div class="artwork-actions">
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer'): ?>
                                <form method="post" action="index.php?action=buy-artwork" style="display: inline;">
                                    <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                                    <button type="submit" class="btn btn-buy" 
                                            onclick="return confirm('Purchase this artwork for $<?php echo number_format($artwork['starting_price'], 2); ?>?')">
                                        🛒 Buy Now
                                    </button>
                                </form>
                            <?php elseif (!isset($_SESSION['user'])): ?>
                                <a href="index.php?action=login" class="btn btn-buy">
                                    🔐 Login to Purchase
                                </a>
                            <?php else: ?>
                                <span class="btn btn-disabled">
                                    Only buyers can purchase
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($artwork['status'] === 'in_auction'): ?>
                        <div class="price-label">Current Auction Status</div>
                        <div class="price-amount">
                            $<?php echo number_format($artwork['current_bid'] ?: $artwork['starting_price'], 2); ?>
                        </div>
                        
                        <div class="artwork-actions">
                            <a href="index.php?action=auction-details&id=<?php echo $artwork['id']; ?>" class="btn btn-auction">
                                🏆 Join Auction
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="price-label">Sold For</div>
                        <div class="price-amount">$<?php echo number_format($artwork['final_sale_price'], 2); ?></div>
                        
                        <div class="artwork-actions">
                            <span class="btn btn-disabled">
                                ✅ Sold
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="artwork-meta">
            <div class="meta-grid">
                <div class="meta-item">
                    <div class="meta-label">Created</div>
                    <div class="meta-value"><?php echo date('M j, Y', strtotime($artwork['created_at'])); ?></div>
                </div>
                
                <div class="meta-item">
                    <div class="meta-label">Status</div>
                    <div class="meta-value"><?php echo ucwords(str_replace('_', ' ', $artwork['status'])); ?></div>
                </div>
                
                <div class="meta-item">
                    <div class="meta-label">Starting Price</div>
                    <div class="meta-value">$<?php echo number_format($artwork['starting_price'], 2); ?></div>
                </div>
                
                <?php if ($artwork['status'] === 'in_auction'): ?>
                    <div class="meta-item">
                        <div class="meta-label">Auction Ends</div>
                        <div class="meta-value"><?php echo date('M j, Y', strtotime($artwork['auction_end_time'])); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if ($artwork['final_sale_price']): ?>
                    <div class="meta-item">
                        <div class="meta-label">Sale Price</div>
                        <div class="meta-value">$<?php echo number_format($artwork['final_sale_price'], 2); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>