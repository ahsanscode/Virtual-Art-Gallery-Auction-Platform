<?php
require_once __DIR__ . '/../models/user/User.php';

class ProfileController
{
    public function showProfile()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user']['id']);
        
        if (!$user) {
            $error = "User not found.";
            include __DIR__ . '/../views/profile.php';
            return;
        }

        include __DIR__ . '/../views/profile.php';
    }

    public function updateProfile()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = $_SESSION['user']['id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $role = $_POST['role'] ?? $_SESSION['user']['role'];

            $userModel = new User();
            
            // Validate input
            if (empty($name) || empty($email)) {
                $error = "Name and email are required.";
                $user = $userModel->findById($userId);
                include __DIR__ . '/../views/profile.php';
                return;
            }

            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address.";
                $user = $userModel->findById($userId);
                include __DIR__ . '/../views/profile.php';
                return;
            }

            // Check if name already exists for another user
            if ($userModel->checkNameExists($name, $userId)) {
                $error = "Name already exists. Please choose a different name.";
                $user = $userModel->findById($userId);
                include __DIR__ . '/../views/profile.php';
                return;
            }

            // Check if email already exists for another user
            if ($userModel->checkEmailExists($email, $userId)) {
                $error = "Email already exists. Please choose a different email.";
                $user = $userModel->findById($userId);
                include __DIR__ . '/../views/profile.php';
                return;
            }

            // Update profile information
            if ($userModel->updateProfile($userId, $name, $email)) {
                // Update session data
                $_SESSION['user']['username'] = $name;
                $_SESSION['user']['email'] = $email;
                
                // Update role if it changed
                if ($role !== $_SESSION['user']['role']) {
                    if ($userModel->updateRole($userId, $role)) {
                        $_SESSION['user']['role'] = $role;
                        $success = "Profile and role updated successfully! You are now a " . ucfirst($role) . ".";
                    } else {
                        $error = "Profile updated but failed to update role.";
                    }
                } else {
                    $success = "Profile updated successfully!";
                }
            } else {
                $error = "Failed to update profile. Please try again.";
            }

            // Get updated user data
            $user = $userModel->findById($userId);
            include __DIR__ . '/../views/profile.php';
        } else {
            $this->showProfile();
        }
    }
}
?>