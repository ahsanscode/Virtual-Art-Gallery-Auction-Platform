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
    
    .page-title {
        color: #333;
        margin: 0;
    }
    
    .add-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }
    
    .add-btn:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
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
        background: linear-gradient(45deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        position: relative;
    }
    
    .artwork-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .artwork-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-available {
        background: #28a745;
        color: white;
    }
    
    .status-sold {
        background: #dc3545;
        color: white;
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
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    .artwork-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .bids-section {
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }
    
    .bids-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .bid-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .bid-info {
        flex: 1;
    }
    
    .bid-amount {
        font-weight: 600;
        color: #333;
    }
    
    .bid-buyer {
        font-size: 0.9rem;
        color: #666;
    }
    
    .approve-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
    }
    
    .approve-btn:hover {
        background: #218838;
    }
    
    .no-bids {
        color: #666;
        font-style: italic;
        text-align: center;
        padding: 1rem;
    }
    
    .no-artworks {
        text-align: center;
        padding: 3rem;
        color: #666;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="main-content">
    <div class="container">
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        
        <div class="page-header">
            <h1 class="page-title">My Artworks</h1>
            <a href="index.php?action=add-artwork" class="add-btn">+ Add New Artwork</a>
        </div>
        
        <?php if (empty($artworks)): ?>
            <div class="no-artworks">
                <h3>No artworks yet</h3>
                <p>Start by adding your first artwork to showcase your talent!</p>
                <a href="index.php?action=add-artwork" class="add-btn">Add Your First Artwork</a>
            </div>
        <?php else: ?>
            <div class="artworks-grid">
                <?php foreach ($artworks as $artwork): ?>
                    <div class="artwork-card">
                        <div class="artwork-image">
                            <?php if ($artwork['image_path']): ?>
                                <img src="<?php echo htmlspecialchars($artwork['image_path']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>">
                            <?php else: ?>
                                🎨
                            <?php endif; ?>
                            <div class="artwork-status status-<?php echo $artwork['status']; ?>">
                                <?php echo ucfirst($artwork['status']); ?>
                            </div>
                        </div>
                        
                        <div class="artwork-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                            <?php if ($artwork['description']): ?>
                                <div class="artwork-description"><?php echo htmlspecialchars($artwork['description']); ?></div>
                            <?php endif; ?>
                            <div class="artwork-price">
                                Initial: $<?php echo number_format($artwork['initial_price'], 2); ?>
                                <?php if ($artwork['current_price'] > $artwork['initial_price']): ?>
                                    | Current: $<?php echo number_format($artwork['current_price'], 2); ?>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($artwork['status'] === 'available'): ?>
                                <div class="bids-section">
                                    <div class="bids-title">Bids (<?php echo count($artwork['bids']); ?>)</div>
                                    <?php if (empty($artwork['bids'])): ?>
                                        <div class="no-bids">No bids yet</div>
                                    <?php else: ?>
                                        <?php foreach ($artwork['bids'] as $bid): ?>
                                            <div class="bid-item">
                                                <div class="bid-info">
                                                    <div class="bid-amount">$<?php echo number_format($bid['bid_amount'], 2); ?></div>
                                                    <div class="bid-buyer">by <?php echo htmlspecialchars($bid['buyer_name']); ?></div>
                                                </div>
                                                <form method="POST" action="index.php?action=approve-bid" style="display: inline;">
                                                    <input type="hidden" name="bid_id" value="<?php echo $bid['id']; ?>">
                                                    <button type="submit" class="approve-btn" onclick="return confirm('Are you sure you want to approve this bid? This will complete the sale.')">
                                                        Approve
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>