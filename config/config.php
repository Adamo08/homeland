<?php
    // Define database configuration constants if not already defined
    if (!defined('DB_HOST')) {
        define('DB_HOST', 'localhost');
    }
    if (!defined('DB_PORT')) {
        define('DB_PORT', '4306'); // Database port (change this to your own!)
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', 'homeland'); // Database name
    }
    if (!defined('DB_USER')) {
        define('DB_USER', 'root');     // Database username
    }
    if (!defined('DB_PASS')) {
        define('DB_PASS', '');         // Database password
    }

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Optional: set the default fetch mode to associative array
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // echo "Database connection successful.";
    } catch (PDOException $e) {
        // Handle connection errors
        echo "Database connection failed: " . $e->getMessage();
    }


