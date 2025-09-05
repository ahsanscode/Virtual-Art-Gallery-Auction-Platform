<?php include 'header.php'; ?>
<style>
    .main-content {
        min-height: calc(100vh - 140px);
        display: flex;
        flex-direction: column;
    }
    
    .hero-section {
        background: linear-gradient(rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600"><rect fill="%23f0f0f0" width="1000" height="600"/><g fill="%23ddd"><rect x="100" y="100" width="200" height="150"/><rect x="350" y="80" width="180" height="200"/><rect x="580" y="120" width="160" height="140"/><rect x="780" y="90" width="140" height="180"/></g></svg>');
        background-size: cover;
        background-position: center;
        color: white;
        text-align: center;
        padding: 5rem 2rem;
    }
    
    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    
    .hero-content p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .cta-btn {
        display: inline-block;
        padding: 1rem 2rem;
        background: white;
        color: #667eea;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    
    .cta-btn.secondary {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .cta-btn.secondary:hover {
        background: white;
        color: #667eea;
    }
    
    .features-section {
        padding: 4rem 2rem;
        background: #f8f9fa;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
    }
    
    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .feature-card h3 {
        margin-bottom: 1rem;
        color: #333;
    }
    
    .stats-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        text-align: center;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .stat-item h3 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    .section-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .success-message {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin: 2rem auto;
        max-width: 600px;
    }
    
    .section-subtitle {
        text-align: center;
        font-size: 1.2rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-content p {
            font-size: 1.1rem;
        }
        
        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="main-content">
    <?php if (isset($_SESSION['delete_success'])): ?>
        <div class="success-message">
            <?php 
            echo htmlspecialchars($_SESSION['delete_success']); 
            unset($_SESSION['delete_success']);
            ?>
        </div>
    <?php endif; ?>
    
    <section class="hero-section">
        <div class="hero-content">
            <h1>Discover Extraordinary Art</h1>
            <p>Connect with talented artists and discover unique artworks from around the world. Buy, sell, and auction art in our vibrant community.</p>
            <div class="cta-buttons">
                <a href="index.php?action=signup" class="cta-btn">Join Our Community</a>
                <a href="index.php?action=browse" class="cta-btn secondary">Browse Artworks</a>
            </div>
        </div>
    </section>
    
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose VirtArt Gallery?</h2>
            <p class="section-subtitle">Experience the future of art trading with our comprehensive platform designed for artists and collectors alike.</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h3>For Artists</h3>
                    <p>Showcase your creations, reach a global audience, and monetize your passion. Our platform provides all the tools you need to succeed.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🛒</div>
                    <h3>For Collectors</h3>
                    <p>Discover unique pieces, participate in exciting auctions, and build your personal collection with confidence and security.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3>Live Auctions</h3>
                    <p>Experience the thrill of live bidding on exclusive artworks. Fair, transparent, and exciting auction environment.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="stats-section">
        <div class="container">
            <h2>Join Our Growing Community</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Active Artists</p>
                </div>
                <div class="stat-item">
                    <h3>2,000+</h3>
                    <p>Artworks Listed</p>
                </div>
                <div class="stat-item">
                    <h3>1,200+</h3>
                    <p>Happy Collectors</p>
                </div>
                <div class="stat-item">
                    <h3>150+</h3>
                    <p>Auctions Completed</p>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>