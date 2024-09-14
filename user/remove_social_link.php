<?php

    require_once "../config/config.php";
    require_once "../functions/database.php";
    require_once "../functions/helpers.php";


    session_start();
    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

    $response = ['status' => 'error', 'message' => 'Invalid request'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        $social = isset($_POST['social']) ? trim($_POST['social']) : '';

        if ($userId > 0 && !empty($social)) {
            // Assuming you have a function to update social links
            $removeSuccess = removeSocialLink($userId, $social);
            
            if ($removeSuccess) {
                $response = ['status' => 'success', 'message' => 'Social link removed successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to remove social link.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Missing parameters.'];
        }
    }


    header('Content-Type: application/json');
    echo json_encode($response);
