<?php include 'header.php'; ?>

<style>
    .main-content {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 1rem;
    }
    
    .signup-container {
        max-width: 400px;
        width: 100%;
        padding: 2.5rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    
    .signup-container h2 {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .signup-container form {
        display: flex;
        flex-direction: column;
    }
    
    .signup-container input[type="text"],
    .signup-container input[type="email"],
    .signup-container input[type="password"],
    .signup-container select {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        background: #f8f9fa;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .signup-container input[type="text"]:focus,
    .signup-container input[type="email"]:focus,
    .signup-container input[type="password"]:focus,
    .signup-container select:focus {
        border-color: #667eea;
        outline: none;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .signup-container input[type="submit"] {
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .signup-container input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .signup-container p {
        text-align: center;
        margin-top: 1.5rem;
        color: #666;
    }
    
    .signup-container a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    
    .signup-container a:hover {
        text-decoration: underline;
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
    
    @media (max-width: 480px) {
        .signup-container {
            padding: 1.5rem 1rem;
            margin: 0 1rem;
        }
        
        .signup-container h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-content">
    <div class="signup-container">
        <h2>Join Our Community</h2>
        <?php if (!empty($error)) echo "<div class='error-message'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div class='success-message'>$success</div>"; ?>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">Select your role</option>
                <option value="artist">Artist</option>
                <option value="buyer">Buyer</option>
            </select>
            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="index.php?action=login">Login here</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>