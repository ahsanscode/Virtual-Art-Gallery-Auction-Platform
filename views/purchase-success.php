<?php include 'header.php'; ?>

<style>
    .main-content {
        min-height: calc(100vh - 140px);
        padding: 2rem;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .success-container {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
        max-width: 600px;
        width: 100%;
    }
    
    .success-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    
    .success-title {
        color: #28a745;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .success-message {
        color: #666;
        font-size: 1.2rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .artwork-details {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .artwork-image {
        width: 200px;
        height: 150px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        margin: 0 auto 1rem;
    }
    
    .artwork-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .artwork-artist {
        color: #667eea;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .purchase-price {
        font-size: 2rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-secondary {
        background: #f8f9fa;
        color: #333;
        border: 2px solid #e1e5e9;
    }
    
    .purchase-info {
        background: #e8f5e8;
        border-left: 4px solid #28a745;
        padding: 1rem;
        margin-bottom: 2rem;
        border-radius: 0 8px 8px 0;
        text-align: left;
    }
    
    .purchase-info h4 {
        color: #155724;
        margin-bottom: 0.5rem;
    }
    
    .purchase-info p {
        color: #155724;
        margin: 0;
        font-size: 0.9rem;
    }
</style>

<div class="main-content">
    <div class="success-container">
        <div class="success-icon">🎉</div>
        <h1 class="success-title">Purchase Successful!</h1>
        <p class="success-message">
            Congratulations! You have successfully purchased this amazing artwork. 
            The artist will be notified and you will receive further instructions shortly.
        </p>
        
        <?php if (isset($artwork)): ?>
            <div class="artwork-details">
                <div class="artwork-image" style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');"></div>
                <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                <div class="artwork-artist">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                <div class="purchase-price">$<?php echo number_format($artwork['final_sale_price'], 2); ?></div>
            </div>
            
            <div class="purchase-info">
                <h4>📋 Purchase Details</h4>
                <p><strong>Purchase Date:</strong> <?php echo date('F j, Y g:i A'); ?></p>
                <p><strong>Transaction ID:</strong> #<?php echo $artwork['id']; ?>-<?php echo time(); ?></p>
                <p><strong>Status:</strong> Completed</p>
            </div>
        <?php endif; ?>
        
        <div class="action-buttons">
            <a href="index.php?action=browse" class="btn btn-secondary">
                🖼️ Browse More Art
            </a>
            <a href="index.php" class="btn btn-primary">
                🏠 Go to Dashboard
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>