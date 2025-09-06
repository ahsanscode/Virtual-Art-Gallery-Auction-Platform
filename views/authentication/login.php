<?php include __DIR__ . '/../header.php'; ?>

<style>
    .main-content {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 1rem;
    }
    
    .login-container {
        max-width: 400px;
        width: 100%;
        padding: 2.5rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    
    .login-container h2 {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .login-container form {
        display: flex;
        flex-direction: column;
    }
    
    .login-container input[type="email"],
    .login-container input[type="password"] {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        background: #f8f9fa;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .login-container input[type="email"]:focus,
    .login-container input[type="password"]:focus {
        border-color: #667eea;
        outline: none;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .login-container input[type="submit"] {
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
    
    .login-container input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .login-container p {
        text-align: center;
        margin-top: 1.5rem;
        color: #666;
    }
    
    .login-container a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    
    .login-container a:hover {
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
        .login-container {
            padding: 1.5rem 1rem;
            margin: 0 1rem;
        }
        
        .login-container h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-content">
    <div class="login-container">
        <h2>Welcome Back</h2>
        <?php if (!empty($success)) echo "<div class='success-message'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='error-message'>$error</div>"; ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="index.php?action=signup">Join our community</a></p>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>