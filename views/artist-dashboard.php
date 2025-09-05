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
        border-left: 4px solid #667eea;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #667eea;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .action-icon {
        font-size: 1.2rem;
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
        background: #667eea;
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
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h1>
                <p>Manage your artworks and track your success as an artist</p>
            </div>
            <div style="color: #667eea; font-size: 3rem;">🎨</div>
        </div>
        
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Artworks Listed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">45</div>
                <div class="stat-label">Total Views</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">8</div>
                <div class="stat-label">Artworks Sold</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$2,450</div>
                <div class="stat-label">Total Earnings</div>
            </div>
        </div>
        
        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="action-buttons">
                <a href="index.php?action=add-artwork" class="action-btn">
                    <span class="action-icon">➕</span>
                    Add New Artwork
                </a>
                <a href="index.php?action=my-artworks" class="action-btn">
                    <span class="action-icon">🖼️</span>
                    Manage Artworks
                </a>
                <a href="index.php?action=sales-report" class="action-btn">
                    <span class="action-icon">📊</span>
                    Sales Report
                </a>
                <a href="index.php?action=profile-settings" class="action-btn">
                    <span class="action-icon">⚙️</span>
                    Profile Settings
                </a>
            </div>
        </div>
        
        <div class="recent-activity">
            <h2 class="section-title">Recent Activity</h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">🎨</div>
                    <div class="activity-content">
                        <div class="activity-title">New artwork "Sunset Dreams" was listed</div>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">💰</div>
                    <div class="activity-content">
                        <div class="activity-title">Artwork "Ocean Waves" was sold for $350</div>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">👁️</div>
                    <div class="activity-content">
                        <div class="activity-title">Your portfolio received 15 new views</div>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">⭐</div>
                    <div class="activity-content">
                        <div class="activity-title">Artwork "Mountain Peak" was favorited by 3 users</div>
                        <div class="activity-time">3 days ago</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>