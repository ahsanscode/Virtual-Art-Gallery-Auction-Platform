<?php include 'header.php'; ?>

<style>
    .main-content {
        min-height: calc(100vh - 140px);
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 2rem 1rem;
    }
    
    .profile-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .profile-header h1 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .profile-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .profile-form {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }
    
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group select {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        background: #f8f9fa;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group select:focus {
        border-color: #667eea;
        outline: none;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .role-toggle {
        background: #f8f9fa;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        padding: 1rem;
    }
    
    .role-toggle label {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        display: block;
    }
    
    .role-options {
        display: flex;
        gap: 1rem;
    }
    
    .role-option {
        flex: 1;
        position: relative;
    }
    
    .role-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .role-option-label {
        display: block;
        padding: 1rem;
        background: white;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .role-option input[type="radio"]:checked + .role-option-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
    }
    
    .role-option-label:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    
    .role-option input[type="radio"]:checked + .role-option-label:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }
    
    .role-description {
        margin-top: 1rem;
        padding: 1rem;
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #856404;
    }
    
    .btn-update {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .btn-delete {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
    }
    
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .button-group .btn-update,
    .button-group .btn-delete {
        width: 48%;
        margin-top: 0;
    }
    
    .current-info {
        background: #e7f3ff;
        border: 1px solid #b3d9ff;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .current-info h3 {
        color: #0066cc;
        margin-bottom: 0.5rem;
    }
    
    .current-info p {
        margin: 0.25rem 0;
        color: #333;
    }
    
    .error-message {
        color: #dc3545;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .success-message {
        color: #155724;
        background: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .profile-container {
            margin: 0 1rem;
        }
        
        .role-options {
            flex-direction: column;
        }
        
        .profile-header h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-content">
    <div class="profile-container">
        <div class="profile-header">
            <h1>👤 User Profile</h1>
            <p>Manage your account information and preferences</p>
        </div>
        
        <div class="profile-form">
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <?php if (isset($user)): ?>
                <div class="current-info">
                    <h3>Current Information</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Current Role:</strong> <span style="color: #667eea; font-weight: bold;"><?php echo ucfirst($user['role']); ?></span></p>
                    <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                </div>
                
                <form method="post" action="index.php?action=update-profile">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <div class="role-toggle">
                            <label>Account Type</label>
                            <div class="role-options">
                                <div class="role-option">
                                    <input type="radio" id="role-buyer" name="role" value="buyer" <?php echo $user['role'] === 'buyer' ? 'checked' : ''; ?>>
                                    <label for="role-buyer" class="role-option-label">
                                        🛒 Buyer
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" id="role-artist" name="role" value="artist" <?php echo $user['role'] === 'artist' ? 'checked' : ''; ?>>
                                    <label for="role-artist" class="role-option-label">
                                        🎨 Artist
                                    </label>
                                </div>
                            </div>
                            <div class="role-description">
                                <strong>Note:</strong> Changing your role will update your dashboard and available features. 
                                As a <strong>Buyer</strong>, you can browse and purchase artworks. 
                                As an <strong>Artist</strong>, you can create and sell your artworks.
                            </div>
                        </div>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn-update">Update Profile</button>
                        <button type="button" class="btn-delete" onclick="confirmDelete()">Delete Profile</button>
                    </div>
                </form>
                
                <form id="deleteForm" method="post" action="index.php?action=delete-profile" style="display: none;">
                </form>
                
                <script>
                function confirmDelete() {
                    if (confirm('Are you sure you want to delete your profile? This action cannot be undone and will log you out immediately.')) {
                        document.getElementById('deleteForm').submit();
                    }
                }
                </script>
            <?php else: ?>
                <div class="error-message">Unable to load user information.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>