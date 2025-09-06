<?php include 'header.php'; ?>

<style>
    .main-content {
        min-height: calc(100vh - 140px);
        padding: 2rem;
        background: #f8f9fa;
    }
    
    .container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-container {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .form-header h1 {
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .form-header p {
        color: #666;
        font-size: 1.1rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
        width: 100%;
    }
    
    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-input-display {
        padding: 0.75rem;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        background: #f8f9fa;
        color: #666;
        text-align: center;
        transition: border-color 0.3s ease;
    }
    
    .file-input-display:hover {
        border-color: #667eea;
        background: #f0f2ff;
    }
    
    .submit-btn {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
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
    
    .back-link {
        color: #667eea;
        text-decoration: none;
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="main-content">
    <div class="container">
        <a href="index.php?action=my-artworks" class="back-link">← Back to My Artworks</a>
        
        <div class="form-container">
            <div class="form-header">
                <h1>🎨 Add New Artwork</h1>
                <p>Share your creativity with the world</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="post" action="index.php?action=add-artwork" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Artwork Title *</label>
                    <input type="text" id="title" name="title" required 
                           placeholder="Enter a captivating title for your artwork">
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" 
                              placeholder="Describe your artwork, inspiration, technique, or story behind it..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Artwork Image *</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" class="file-input" 
                               accept="image/jpeg,image/png,image/gif" required>
                        <div class="file-input-display" id="file-display">
                            📷 Click to select an image (JPEG, PNG, GIF - Max 5MB)
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="starting_price">Starting Price (USD) *</label>
                    <input type="number" id="starting_price" name="starting_price" 
                           min="1" step="0.01" required
                           placeholder="Enter starting price (e.g., 100.00)">
                </div>
                
                <button type="submit" class="submit-btn">✨ Add Artwork</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const fileDisplay = document.getElementById('file-display');
    const file = e.target.files[0];
    
    if (file) {
        fileDisplay.textContent = `📷 Selected: ${file.name}`;
        fileDisplay.style.color = '#667eea';
    } else {
        fileDisplay.textContent = '📷 Click to select an image (JPEG, PNG, GIF - Max 5MB)';
        fileDisplay.style.color = '#666';
    }
});
</script>

<?php include 'footer.php'; ?>