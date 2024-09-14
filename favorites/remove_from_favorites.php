

<?php

    require_once "../config/config.php";
    require_once "../functions/database.php";

    session_start();
    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

    if (isset($_POST['property_id']) && isset($_POST['user_id'])) {
        $propertyId = $_POST['property_id'];
        $userId = $_POST['user_id'];


        if (removeFromFavorites($userId,$propertyId)) {
            $response = ['status' => 'success', 'message' => 'Property removed from favorites'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to remove property'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid request'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
