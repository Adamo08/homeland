

<?php

    require_once "../config/config.php";
    require_once "../functions/database.php";

    session_start();
    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
        
        if ($requestId > 0){
            if (removeFromRequests($requestId)) {
                $response = ['status' => 'success', 'message' => 'Property removed from requests'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to remove property'];
            }
        }

    } else {
        $response = ['status' => 'error', 'message' => 'Invalid request'];
    }


    
    header('Content-Type: application/json');
    echo json_encode($response);
