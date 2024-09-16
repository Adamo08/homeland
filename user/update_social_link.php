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
        $newUrl = isset($_POST['new_url']) ? trim($_POST['new_url']) : '';

        if ($userId > 0 && !empty($social) && !empty($newUrl)) {

            $updateSuccess = updateSocialLink($userId, $social, $newUrl);
            
            if ($updateSuccess) {
                $response = ['status' => 'success', 'message' => 'Social link updated successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to update social link.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Missing parameters.'];
        }
    }


    header('Content-Type: application/json');
    echo json_encode($response);
