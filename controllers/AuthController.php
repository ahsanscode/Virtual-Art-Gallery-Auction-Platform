<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
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
                include __DIR__ . '/../views/login.php';
            }
        } else {
            include __DIR__ . '/../views/login.php';
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
            if ($userModel->findByEmail($email) || $userModel->findByName($name)) {
                $error = "Email or name already exists.";
                include __DIR__ . '/../views/signup.php';
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if ($userModel->create($name, $email, $hashedPassword, $role)) {
                $success = "Registration successful! Please login.";
                $error = ""; // Clear any previous errors
                include __DIR__ . '/../views/login.php';
            } else {
                $error = "Registration failed. Please try again.";
                include __DIR__ . '/../views/signup.php';
            }
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