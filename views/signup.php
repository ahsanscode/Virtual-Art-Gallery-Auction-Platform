<?php //include 'header.php'; ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up - Virtual Art Gallery</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                background: #f6f6f6;
                font-family: 'Segoe UI', Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            .signup-container {
                max-width: 400px;
                margin: 70px auto;
                padding: 36px 30px 28px 30px;
                background: #fff;
                border-radius: 14px;
                box-shadow: 0 8px 30px rgba(60, 60, 90, 0.07);
            }
            .signup-container h2 {
                text-align: center;
                margin-bottom: 24px;
                color: #2a2a39;
            }
            .signup-container form {
                display: flex;
                flex-direction: column;
            }
            .signup-container input[type="text"],
            .signup-container input[type="email"],
            .signup-container input[type="password"],
            .signup-container select {
                padding: 10px;
                margin-bottom: 18px;
                border: 1px solid #ccc;
                border-radius: 7px;
                background: #fafafa;
                font-size: 16px;
                transition: border-color 0.2s;
            }
            .signup-container input[type="text"]:focus,
            .signup-container input[type="email"]:focus,
            .signup-container input[type="password"]:focus,
            .signup-container select:focus {
                border-color: #8e44ad;
                outline: none;
            }
            .signup-container input[type="submit"] {
                padding: 10px;
                background: linear-gradient(90deg, #8e44ad 0%, #6c3483 100%);
                color: #fff;
                border: none;
                border-radius: 7px;
                font-size: 16px;
                cursor: pointer;
                transition: background 0.2s;
            }
            .signup-container input[type="submit"]:hover {
                background: linear-gradient(90deg, #6c3483 0%, #8e44ad 100%);
            }
            .signup-container p {
                text-align: center;
                margin-top: 14px;
                font-size: 15px;
            }
            .signup-container a {
                color: #8e44ad;
                text-decoration: none;
            }
            .signup-container a:hover {
                text-decoration: underline;
            }
            .error-message {
                color: #c0392b;
                background: #ffeaea;
                border: 1px solid #e0b4b4;
                padding: 10px 12px;
                border-radius: 7px;
                text-align: center;
                margin-bottom: 18px;
            }
            @media (max-width: 480px) {
                .signup-container {
                    padding: 18px 6px;
                    margin: 40px 8px;
                }
            }
        </style>
    </head>
    <body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php if (!empty($error)) echo "<div class='error-message'>$error</div>"; ?>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="artist">Artist</option>
                <option value="buyer">Buyer</option>
            </select>
            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="index.php?action=login">Login</a></p>
    </div>
    </body>
    </html>
<?php //include 'footer.php'; ?>