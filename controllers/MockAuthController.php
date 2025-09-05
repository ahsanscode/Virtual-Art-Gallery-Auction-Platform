<?php
// Simple mock authentication for demonstration purposes
class MockAuthController
{
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Mock authentication - accept any email with password "password123"
            if (!empty($email) && $password === 'password123') {
                // Determine role based on email
                $role = strpos($email, 'artist') !== false ? 'artist' : 'buyer';
                $username = explode('@', $email)[0];
                
                $_SESSION['user'] = [
                    'id' => 1,
                    'username' => $username,
                    'email' => $email,
                    'role' => $role
                ];
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid email or password. Try password123 with any email.";
                include __DIR__ . '/../views/login.php';
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'] ?? 'buyer';

            // Mock signup - just redirect to login with success message
            $success = "Registration successful! Please login with password: password123";
            $error = "";
            include __DIR__ . '/../views/login.php';
        } else {
            include __DIR__ . '/../views/signup.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
?>