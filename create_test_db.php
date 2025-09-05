<?php
// Simple script to create a test database with SQLite for demonstration
$pdo = new PDO('sqlite:test_db.sqlite');

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'buyer'
)";

$pdo->exec($sql);

echo "Test database created successfully with users table.\n";
echo "Fields: id, name, email, password, role\n";
?>