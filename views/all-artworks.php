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
    
    .search-section {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .search-form {
        display: flex;
        gap: 1rem;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .search-input {
        flex: 1;
        min-width: 300px;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #667eea;
    }
    
    .search-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .search-btn:hover {
        transform: translateY(-2px);
    }
    
    .clear-search {
        background: #6c757d;
        color: white;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .clear-search:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .results-info {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        text-align: center;
        color: #666;
    }
    
    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .artwork-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        position: relative;
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
    
    .artwork-type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .badge-available {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .badge-auction {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
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
    
    .artwork-meta {
        font-size: 0.8rem;
        color: #999;
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
    
    .ending-soon {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
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
            <h1>🎨 All Artworks & Auctions</h1>
            <p>Discover and bid on amazing artworks from talented artists</p>
        </div>
        
        <div class="search-section">
            <form method="GET" action="index.php" class="search-form">
                <input type="hidden" name="action" value="all-artworks">
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="🔍 Search artworks by title..." 
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button type="submit" class="search-btn">Search</button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="index.php?action=all-artworks" class="clear-search">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <?php if (!empty($_GET['search'])): ?>
            <div class="results-info">
                <?php 
                $search_term = htmlspecialchars($_GET['search']);
                $count = count($artworks);
                echo "Found {$count} artwork(s) matching \"{$search_term}\"";
                ?>
            </div>
        <?php endif; ?>
        
        <div class="quick-actions">
            <h3>🎯 Quick Actions</h3>
            <div class="action-links">
                <a href="index.php?action=browse" class="action-link">
                    🖼️ Available Artworks Only
                </a>
                <a href="index.php?action=auctions" class="action-link">
                    🏆 Live Auctions Only
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
                <h2><?php echo !empty($_GET['search']) ? 'No artworks found' : 'No artworks available'; ?></h2>
                <p><?php echo !empty($_GET['search']) ? 'Try adjusting your search terms or browse all artworks.' : 'Check back soon for new artworks from our talented artists!'; ?></p>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="index.php?action=all-artworks" class="action-link">
                        🎨 View All Artworks
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="artworks-grid">
                <?php foreach ($artworks as $artwork): ?>
                    <?php 
                        $is_auction = $artwork['status'] === 'in_auction';
                        $time_left = 0;
                        $hours_left = 0;
                        $minutes_left = 0;
                        $is_ending_soon = false;
                        
                        if ($is_auction) {
                            $end_time = strtotime($artwork['auction_end_time']);
                            $current_time = time();
                            $time_left = $end_time - $current_time;
                            $hours_left = floor($time_left / 3600);
                            $minutes_left = floor(($time_left % 3600) / 60);
                            $is_ending_soon = $time_left < 3600; // Less than 1 hour
                        }
                    ?>
                    <div class="artwork-card <?php echo $is_ending_soon ? 'ending-soon' : ''; ?>">
                        <div class="artwork-image" 
                             style="background-image: url('<?php echo htmlspecialchars($artwork['image_url']); ?>');"
                             onclick="location.href='index.php?action=<?php echo $is_auction ? 'auction' : 'artwork'; ?>-details&id=<?php echo $artwork['id']; ?>'">
                            
                            <div class="artwork-type-badge <?php echo $is_auction ? 'badge-auction' : 'badge-available'; ?>">
                                <?php echo $is_auction ? '🏆 Live Auction' : '🖼️ Available'; ?>
                            </div>
                            
                            <?php if ($is_auction): ?>
                                <div class="time-remaining">
                                    <?php if ($time_left > 0): ?>
                                        ⏰ <?php echo $hours_left; ?>h <?php echo $minutes_left; ?>m
                                    <?php else: ?>
                                        ⏰ Ended
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="artwork-info">
                            <div class="artwork-title"><?php echo htmlspecialchars($artwork['title']); ?></div>
                            <div class="artwork-artist">by <?php echo htmlspecialchars($artwork['artist_name']); ?></div>
                            
                            <?php if ($artwork['description']): ?>
                                <div class="artwork-description"><?php echo htmlspecialchars($artwork['description']); ?></div>
                            <?php endif; ?>
                            
                            <?php if ($is_auction): ?>
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
                            <?php else: ?>
                                <div class="artwork-price">
                                    $<?php echo number_format($artwork['starting_price'], 2); ?>
                                </div>
                                
                                <div class="artwork-meta">
                                    Added: <?php echo date('M j, Y', strtotime($artwork['created_at'])); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="artwork-actions">
                                <?php if ($is_auction): ?>
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
                                <?php else: ?>
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
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Auto-refresh page every 30 seconds to update auction times for auction items
let hasAuctionItems = <?php echo json_encode(array_filter($artworks, function($a) { return $a['status'] === 'in_auction'; })); ?>.length > 0;
if (hasAuctionItems) {
    setTimeout(function() {
        // Only reload if no search is active to preserve user experience
        if (!window.location.search.includes('search=')) {
            location.reload();
        }
    }, 30000);
}
</script>

<?php include 'footer.php'; ?>