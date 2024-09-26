<?php
        // Include your database connection
        include 'c:/xampp/htdocs/Homeland/config/config.php';

        // Query to get the number of users registered each month
        $query = "SELECT 
                        MONTHNAME(created_at) AS month, 
                        COUNT(id) AS user_count 
                        FROM users 
                        WHERE YEAR(created_at) = 2024
                        GROUP BY MONTH(created_at), YEAR(created_at) 
                        ORDER BY YEAR(created_at), MONTH(created_at)
                ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        // Return data as JSON
        echo json_encode($result);

