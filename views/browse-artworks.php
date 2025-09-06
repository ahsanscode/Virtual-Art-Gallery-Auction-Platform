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
    
    .page-title {
        color: #333;
        margin: 0 0 0.5rem 0;
    }
    
    .page-subtitle {
        color: #666;
        margin: 0;
    }
    
    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
        color: #666;
        margin-bottom: 0.5rem;
    }
    
    .artwork-description {
        color: #666;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    .price-info {
        margin-bottom: 1rem;
    }
    
    .current-price {
        font-size: 1.2rem;
        font-weight: 600;
        color: #28a745;
    }
    
    .highest-bid {
        font-size: 0.9rem;
        color: #666;
        margin-top: 0.25rem;
    }
    
    .bid-form {
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }
    
    .bid-input-group {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .bid-input {
        flex: 1;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
    }
    
    .bid-btn {
        background: #667eea;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    
    .bid-btn:hover {
        background: #5a6fd8;
    }
    
    .minimum-bid {
        font-size: 0.8rem;
        color: #666;
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
    
    @media (max-width: 768px) {
        .artworks-grid {
            grid-template-columns: 1fr;
        }
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
            <h1 class="page-title">Browse Artworks</h1>
            <p class="page-subtitle">Discover amazing artworks and place your bids</p>
        </div>
        
        <?php if (empty($artworks)): ?>
            <div class="no-artworks">
                <h3>No artworks available</h3>
                <p>Check back later for new artworks from our talented artists!</p>
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
                        </div>
                        
                        <div class="artwork-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                            <?php if ($artwork['description']): ?>
                                <div class="artwork-description"><?php echo htmlspecialchars($artwork['description']); ?></div>
                            <?php endif; ?>
                            
                            <div class="price-info">
                                <div class="current-price">
                                    $<?php echo number_format($artwork['current_price'], 2); ?>
                                </div>
                                <?php if ($artwork['highest_bid'] > 0): ?>
                                    <div class="highest-bid">
                                        Highest bid: $<?php echo number_format($artwork['highest_bid'], 2); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($_SESSION['user']['role'] === 'buyer'): ?>
                                <div class="bid-form">
                                    <form method="POST" action="index.php?action=place-bid">
                                        <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                                        <div class="bid-input-group">
                                            <input type="number" 
                                                   name="bid_amount" 
                                                   class="bid-input" 
                                                   placeholder="Enter bid amount"
                                                   min="<?php echo max($artwork['current_price'], $artwork['highest_bid'] + 1); ?>"
                                                   step="0.01" 
                                                   required>
                                            <button type="submit" class="bid-btn">Place Bid</button>
                                        </div>
                                        <div class="minimum-bid">
                                            Minimum bid: $<?php echo number_format(max($artwork['current_price'], $artwork['highest_bid'] + 1), 2); ?>
                                        </div>
                                    </form>
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