<?php
require_once __DIR__ . '/../../models/user/User.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmailIncludingDeleted($email);

            if ($user && password_verify($password, $user['password'])) {
                // Check if user is soft deleted
                if ($user['is_deleted'] == 1) {
                    $error = "The profile was deleted contact authority";
                    include __DIR__ . '/../../views/authentication/login.php';
                    return;
                }
                
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['name'], // Display name in header
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid email or password.";
                include __DIR__ . '/../../views/authentication/login.php';
            }
        } else {
            include __DIR__ . '/../../views/authentication/login.php';
        }
    }

    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'] ?? 'buyer';

            $userModel = new User();
            
            // Check if email already exists (emails must be unique)
            if ($userModel->findByEmail($email)) {
                $error = "An account with this email already exists. Please choose a different email.";
                include __DIR__ . '/../../views/authentication/signup.php';
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if ($userModel->create($name, $email, $hashedPassword, $role)) {
                $success = "Registration successful! Please login.";
                $error = ""; // Clear any previous errors
                include __DIR__ . '/../../views/authentication/login.php';
            } else {
                $error = "Registration failed. Please try again.";
                include __DIR__ . '/../../views/authentication/signup.php';
            }
        } else {
            include __DIR__ . '/../../views/authentication/signup.php';
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