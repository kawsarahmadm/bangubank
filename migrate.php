<?php

// Database connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Set up DSN for connecting to the MySQL server (without specifying a database)
$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Connect to the MySQL server
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected to the MySQL server successfully!\n";

    // SQL to create the banking_app database
    $sql = "CREATE DATABASE IF NOT EXISTS banking_app";
    $pdo->exec($sql);
    echo "Database 'banking_app' created successfully!\n";

    // Switch to the newly created database
    $pdo->exec("USE banking_app");

    // SQL to create the users table
    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'customer') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        account_no VARCHAR(255) NOT NULL UNIQUE
    )";
    $pdo->exec($sql);
    echo "Table 'users' created successfully!\n";

    // SQL to create the transactions table
    $sql = "
    CREATE TABLE IF NOT EXISTS transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        date DATETIME NOT NULL,
        type ENUM('deposit', 'withdraw', 'transfer') NOT NULL,
        account VARCHAR(255) NOT NULL,
        toAccount VARCHAR(255) DEFAULT NULL,
        CONSTRAINT fk_account FOREIGN KEY (account) REFERENCES users(email) ON DELETE CASCADE,
        CONSTRAINT fk_toAccount FOREIGN KEY (toAccount) REFERENCES users(email) ON DELETE SET NULL
    )";
    $pdo->exec($sql);
    echo "Table 'transactions' created successfully!\n";

} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
