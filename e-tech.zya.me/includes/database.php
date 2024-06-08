<?php

// Database configuration
$dbHost = 'localhost';      // Database host 
$dbName = 'e-tech';         // Database name
$dbUser = 'root';           // Database username
$dbPass = '';               // Database password

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable error reporting
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Default fetch mode
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation of prepared statements
];

// Database connection
try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
   // Log the error and display a generic message to the user
    error_log('Database Error: ' . $e->getMessage(), 0);
    header('Location: index.php?page=500');
    exit;
}