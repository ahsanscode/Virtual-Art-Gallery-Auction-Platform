<?php
require_once __DIR__ . '/../../config/Database.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByName($name) {
        $query = "SELECT * FROM " . $this->table . " WHERE name = :name AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmailAndRole($email, $role) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email AND role = :role AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $password, $role = "buyer") {
        $query = "INSERT INTO " . $this->table . " (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $name, $email) {
        $query = "UPDATE " . $this->table . " SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    public function updateRole($id, $role) {
        $query = "UPDATE " . $this->table . " SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    public function checkEmailExists($email, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email AND id != :excludeId AND deleted_at IS NULL LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":excludeId", $excludeId);
        } else {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email AND deleted_at IS NULL LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkNameExists($name, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT * FROM " . $this->table . " WHERE name = :name AND id != :excludeId AND deleted_at IS NULL LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":excludeId", $excludeId);
        } else {
            $query = "SELECT * FROM " . $this->table . " WHERE name = :name AND deleted_at IS NULL LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $name);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function softDelete($id) {
        $query = "UPDATE " . $this->table . " SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>