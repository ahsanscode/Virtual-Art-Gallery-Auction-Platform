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
    
    .form-title {
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
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
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .submit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.2s ease;
        width: 100%;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
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
    
    .back-link {
        display: inline-block;
        color: #667eea;
        text-decoration: none;
        margin-bottom: 1rem;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="main-content">
    <div class="container">
        <a href="index.php?action=my-artworks" class="back-link">← Back to My Artworks</a>
        
        <div class="form-container">
            <h1 class="form-title">Add New Artwork</h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Artwork Title *</label>
                    <input type="text" id="title" name="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Describe your artwork..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Artwork Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small style="color: #666; display: block; margin-top: 0.25rem;">Supported formats: JPG, PNG, GIF</small>
                </div>
                
                <div class="form-group">
                    <label for="initial_price">Initial Price ($) *</label>
                    <input type="number" id="initial_price" name="initial_price" step="0.01" min="0.01" required value="<?php echo isset($_POST['initial_price']) ? htmlspecialchars($_POST['initial_price']) : ''; ?>">
                </div>
                
                <button type="submit" class="submit-btn">Add Artwork</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>