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
    
    .auctions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .auction-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        position: relative;
    }
    
    .auction-card:hover {
        transform: translateY(-5px);
    }
    
    .auction-image {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
        cursor: pointer;
    }
    
    .auction-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .time-remaining {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .auction-info {
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
    
    .bid-info {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .current-bid {
        font-size: 1.3rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.5rem;
    }
    
    .bid-details {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: #666;
    }
    
    .user-bid-status {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border-radius: 0 8px 8px 0;
        font-size: 0.9rem;
    }
    
    .user-bid-status.winning {
        background: #e8f5e8;
        border-left-color: #28a745;
        color: #155724;
    }
    
    .user-bid-status.outbid {
        background: #fff3cd;
        border-left-color: #ffc107;
        color: #856404;
    }
    
    .auction-actions {
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
    
    .btn-bid {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
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
    
    .ending-soon {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>🏆 Live Auctions</h1>
            <p>Participate in exciting bidding competitions</p>
        </div>
        
        <div class="quick-nav">
            <div class="nav-links">
                <a href="index.php?action=browse" class="nav-link">
                    🖼️ Browse Artworks
                </a>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer'): ?>
                    <a href="index.php?action=my-bids" class="nav-link">
                        📊 My Bids
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (empty($artworks)): ?>
            <div class="empty-state">
                <h2>No active auctions</h2>
                <p>There are currently no artworks in auction. Check back soon or browse available artworks!</p>
                <a href="index.php?action=browse" class="nav-link">
                    🖼️ Browse Available Artworks
                </a>
            </div>
        <?php else: ?>
            <div class="auctions-grid">
                <?php foreach ($artworks as $artwork): ?>
                    <?php 
                        $end_time = strtotime($artwork['auction_end_time']);
                        $current_time = time();
                        $time_left = $end_time - $current_time;
                        $hours_left = floor($time_left / 3600);
                        $minutes_left = floor(($time_left % 3600) / 60);
                        $is_ending_soon = $time_left < 3600; // Less than 1 hour
                    ?>
                    <div class="auction-card <?php echo $is_ending_soon ? 'ending-soon' : ''; ?>">
                        <div class="auction-image" 
                             style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');"
                             onclick="location.href='index.php?action=auction-details&id=<?php echo $artwork['id']; ?>'">
                            <div class="auction-badge">🏆 Live Auction</div>
                            <div class="time-remaining">
                                <?php if ($time_left > 0): ?>
                                    ⏰ <?php echo $hours_left; ?>h <?php echo $minutes_left; ?>m
                                <?php else: ?>
                                    ⏰ Ended
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="auction-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                            
                            <div class="bid-info">
                                <div class="current-bid">
                                    $<?php echo number_format($artwork['current_bid'], 2); ?>
                                </div>
                                <div class="bid-details">
                                    <span>Starting: $<?php echo number_format($artwork['starting_price'], 2); ?></span>
                                    <span><?php echo $artwork['bid_count']; ?> bid(s)</span>
                                </div>
                            </div>
                            
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer' && isset($artwork['user_has_bid']) && $artwork['user_has_bid']): ?>
                                <div class="user-bid-status <?php echo ($artwork['user_highest_bid'] >= $artwork['current_bid']) ? 'winning' : 'outbid'; ?>">
                                    <?php if ($artwork['user_highest_bid'] >= $artwork['current_bid']): ?>
                                        🎉 You're the highest bidder! ($<?php echo number_format($artwork['user_highest_bid'], 2); ?>)
                                    <?php else: ?>
                                        ⚠️ You've been outbid. Your bid: $<?php echo number_format($artwork['user_highest_bid'], 2); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="auction-actions">
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer' && $time_left > 0): ?>
                                    <a href="index.php?action=auction-details&id=<?php echo $artwork['id']; ?>" 
                                       class="btn btn-bid">
                                        💰 Place Bid
                                    </a>
                                <?php endif; ?>
                                
                                <a href="index.php?action=auction-details&id=<?php echo $artwork['id']; ?>" 
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

<script>
// Auto-refresh page every 30 seconds to update auction times
setTimeout(function() {
    location.reload();
}, 30000);
</script>

<?php include 'footer.php'; ?>