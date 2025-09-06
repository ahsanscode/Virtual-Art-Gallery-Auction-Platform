<?php
// Get bid error/success messages from session and clear them
$bid_error = $_SESSION['bid_error'] ?? '';
$bid_success = $_SESSION['bid_success'] ?? '';
unset($_SESSION['bid_error'], $_SESSION['bid_success']);

include 'header.php'; 
?>

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
    
    .auction-header {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
    }
    
    .artwork-image {
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
    }
    
    .auction-info h1 {
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }
    
    .artist-name {
        color: #667eea;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }
    
    .artwork-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    .auction-status {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .time-remaining {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .time-remaining h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .time-display {
        font-size: 2rem;
        font-weight: 700;
        color: #dc3545;
    }
    
    .bid-section {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .current-bid {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .current-bid h2 {
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .bid-amount {
        font-size: 3rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.5rem;
    }
    
    .bid-count {
        color: #666;
        font-size: 1.1rem;
    }
    
    .bid-form {
        max-width: 400px;
        margin: 0 auto;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }
    
    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 1.1rem;
        transition: border-color 0.3s ease;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #667eea;
    }
    
    .bid-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .bid-btn:hover {
        transform: translateY(-2px);
    }
    
    .bid-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }
    
    .bid-history {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .bid-history h3 {
        color: #333;
        margin-bottom: 1.5rem;
    }
    
    .bid-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .bid-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e1e5e9;
    }
    
    .bid-item:last-child {
        border-bottom: none;
    }
    
    .bid-item.highest {
        background: #e8f5e8;
        border-left: 4px solid #28a745;
    }
    
    .bidder-info {
        flex: 1;
    }
    
    .bidder-name {
        font-weight: 600;
        color: #333;
    }
    
    .bid-time {
        color: #666;
        font-size: 0.9rem;
    }
    
    .bid-amount-item {
        font-size: 1.2rem;
        font-weight: 600;
        color: #28a745;
    }
    
    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #f5c6cb;
    }
    
    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #c3e6cb;
    }
    
    .auction-ended {
        background: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .auction-header {
            grid-template-columns: 1fr;
        }
        
        .bid-amount {
            font-size: 2rem;
        }
    }
</style>

<div class="main-content">
    <div class="container">
        <a href="index.php?action=auctions" class="back-link">← Back to Auctions</a>
        
        <?php 
            $end_time = strtotime($artwork['auction_end_time']);
            $current_time = time();
            $time_left = $end_time - $current_time;
            $auction_ended = $time_left <= 0;
        ?>
        
        <div class="auction-header">
            <div class="artwork-image" style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');"></div>
            
            <div class="auction-info">
                <div class="auction-status">🏆 Live Auction</div>
                <h1><?php echo htmlspecialchars($artwork['title']); ?></h1>
                <div class="artist-name">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                
                <?php if ($artwork['description']): ?>
                    <div class="artwork-description">
                        <?php echo nl2br(htmlspecialchars($artwork['description'])); ?>
                    </div>
                <?php endif; ?>
                
                <div class="time-remaining">
                    <h3>⏰ Time Remaining</h3>
                    <div class="time-display" id="countdown">
                        <?php if ($auction_ended): ?>
                            Auction Ended
                        <?php else: ?>
                            Loading...
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bid-section">
            <?php if ($auction_ended): ?>
                <div class="auction-ended">
                    🏁 This auction has ended
                </div>
            <?php endif; ?>
            
            <div class="current-bid">
                <h2>Current Highest Bid</h2>
                <div class="bid-amount">$<?php echo number_format($current_bid, 2); ?></div>
                <div class="bid-count"><?php echo $bid_count; ?> bid(s) placed</div>
            </div>
            
            <?php if (!$auction_ended && isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer'): ?>
                <?php if (!empty($bid_error)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($bid_error); ?></div>
                <?php endif; ?>
                
                <?php if (!empty($bid_success)): ?>
                    <div class="success-message"><?php echo htmlspecialchars($bid_success); ?></div>
                <?php endif; ?>
                
                <form method="post" action="index.php?action=place-bid" class="bid-form">
                    <input type="hidden" name="artwork_id" value="<?php echo $artwork['id']; ?>">
                    
                    <div class="form-group">
                        <label for="bid_amount">Your Bid Amount (USD)</label>
                        <input type="number" id="bid_amount" name="bid_amount" 
                               min="<?php echo $current_bid + 1; ?>" step="0.01" required
                               placeholder="Minimum: $<?php echo number_format($current_bid + 1, 2); ?>">
                    </div>
                    
                    <button type="submit" class="bid-btn">
                        💰 Place Bid
                    </button>
                </form>
            <?php elseif (!isset($_SESSION['user'])): ?>
                <div style="text-align: center; padding: 1rem;">
                    <p>Please <a href="index.php?action=login">login</a> as a buyer to place bids.</p>
                </div>
            <?php elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] !== 'buyer'): ?>
                <div style="text-align: center; padding: 1rem;">
                    <p>Only buyers can place bids on artworks.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="bid-history">
            <h3>📊 Bid History</h3>
            
            <?php if (empty($bids)): ?>
                <p style="text-align: center; color: #666; padding: 2rem;">No bids placed yet. Be the first to bid!</p>
            <?php else: ?>
                <div class="bid-list">
                    <?php foreach ($bids as $index => $bid): ?>
                        <div class="bid-item <?php echo $index === 0 ? 'highest' : ''; ?>">
                            <div class="bidder-info">
                                <div class="bidder-name">
                                    <?php echo htmlspecialchars($bid['bidder_name']); ?>
                                    <?php if ($index === 0): ?> 👑<?php endif; ?>
                                </div>
                                <div class="bid-time">
                                    <?php echo date('M j, Y g:i A', strtotime($bid['bid_time'])); ?>
                                </div>
                            </div>
                            <div class="bid-amount-item">
                                $<?php echo number_format($bid['bid_amount'], 2); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
<?php if (!$auction_ended): ?>
// Countdown timer
function updateCountdown() {
    const endTime = <?php echo $end_time * 1000; ?>; // Convert to milliseconds
    const now = new Date().getTime();
    const timeLeft = endTime - now;
    
    if (timeLeft <= 0) {
        document.getElementById('countdown').innerHTML = 'Auction Ended';
        setTimeout(() => location.reload(), 1000);
        return;
    }
    
    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
    
    document.getElementById('countdown').innerHTML = 
        hours + 'h ' + minutes + 'm ' + seconds + 's';
}

// Update countdown every second
updateCountdown();
setInterval(updateCountdown, 1000);

// Auto-refresh page every 30 seconds to get new bids
setInterval(() => location.reload(), 30000);
<?php endif; ?>
</script>

<?php include 'footer.php'; ?>