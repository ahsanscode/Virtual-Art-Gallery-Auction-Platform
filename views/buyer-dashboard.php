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
    
    .dashboard-header {
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
    
    .welcome-text h1 {
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .welcome-text p {
        color: #666;
        font-size: 1.1rem;
    }
    
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        text-align: center;
        border-left: 4px solid #28a745;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #666;
        font-size: 1rem;
    }
    
    .quick-actions {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #333;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
    }
    
    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }
    
    .action-icon {
        font-size: 1.2rem;
    }
    
    .featured-artworks {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .artwork-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .artwork-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        background: white;
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
    }
    
    .artwork-info {
        padding: 1rem;
    }
    
    .artwork-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .artwork-artist {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .artwork-price {
        color: #28a745;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .recent-activity {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .activity-list {
        list-style: none;
        padding: 0;
    }
    
    .activity-item {
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        background: #28a745;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        color: #666;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            text-align: center;
        }
        
        .stats-cards {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            grid-template-columns: 1fr;
        }
        
        .artwork-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h1>
                <p>Discover amazing artworks and expand your collection</p>
            </div>
            <div style="color: #28a745; font-size: 3rem;">🛍️</div>
        </div>
        
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number">5</div>
                <div class="stat-label">Artworks Purchased</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Favorites</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3</div>
                <div class="stat-label">Active Bids</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$1,850</div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>
        
        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="action-buttons">
                <a href="index.php?action=browse" class="action-btn">
                    <span class="action-icon">🔍</span>
                    Browse Art
                </a>
                <a href="index.php?action=my-bids" class="action-btn">
                    <span class="action-icon">💰</span>
                    My Bids
                </a>
                <a href="index.php?action=auctions" class="action-btn">
                    <span class="action-icon">🏆</span>
                    Live Auctions
                </a>
                <a href="index.php?action=favorites" class="action-btn">
                    <span class="action-icon">❤️</span>
                    My Favorites
                </a>
                <a href="index.php?action=purchase-history" class="action-btn">
                    <span class="action-icon">📋</span>
                    Purchase History
                </a>
            </div>
        </div>
        
        <div class="featured-artworks">
            <h2 class="section-title">Featured Artworks</h2>
            <div class="artwork-grid">
                <div class="artwork-card">
                    <div class="artwork-image">🌅</div>
                    <div class="artwork-info">
                        <div class="artwork-title">Sunset Dreams</div>
                        <div class="artwork-artist">by Sarah Johnson</div>
                        <div class="artwork-price">$450</div>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">🌊</div>
                    <div class="artwork-info">
                        <div class="artwork-title">Ocean Waves</div>
                        <div class="artwork-artist">by Michael Chen</div>
                        <div class="artwork-price">$320</div>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">🏔️</div>
                    <div class="artwork-info">
                        <div class="artwork-title">Mountain Peak</div>
                        <div class="artwork-artist">by Emma Davis</div>
                        <div class="artwork-price">$680</div>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">🌸</div>
                    <div class="artwork-info">
                        <div class="artwork-title">Cherry Blossoms</div>
                        <div class="artwork-artist">by Hiroshi Tanaka</div>
                        <div class="artwork-price">$290</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="recent-activity">
            <h2 class="section-title">Recent Activity</h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">❤️</div>
                    <div class="activity-content">
                        <div class="activity-title">Added "Abstract Dreams" to favorites</div>
                        <div class="activity-time">1 hour ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">🏆</div>
                    <div class="activity-content">
                        <div class="activity-title">Placed bid on "City Lights" - $425</div>
                        <div class="activity-time">3 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">🛍️</div>
                    <div class="activity-content">
                        <div class="activity-title">Purchased "Forest Path" for $350</div>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">👁️</div>
                    <div class="activity-content">
                        <div class="activity-title">Viewed 12 new artworks in Modern Art category</div>
                        <div class="activity-time">3 days ago</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>