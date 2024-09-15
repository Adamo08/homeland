<?php

    include "../helpers/helpers.php";

    session_start();
    if(!isset($_SESSION['admin_id'])){
        // Go login bro
        echo "<script> window.location.href = '".ADMINAUTH."login.php' </script>";
    }

    // Include your database connection
    include 'c:/xampp/htdocs/Homeland/config/config.php';

    // Query to get the number of users registered each month
    $query = "SELECT 
                    name,
                    property_count
                FROM categories
            ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    echo json_encode($result);