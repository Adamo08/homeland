<?php
    include "../helpers/helpers.php";
    include "../../functions/database.php";

    session_start();
    if(!isset($_SESSION['admin_id'])){
        // Go login bro
        echo "<script> window.location.href = '".ADMINAUTH."login.php' </script>";
        exit();
    }

    
    $response = [
        'status' => 'error', 
        'message' => 'Invalid request'
    ];


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
        $newStatus = isset($_POST['request_status']) ? $_POST['request_status'] : null;

        if ($requestId > 0 && $newStatus){
            // Deleting Property
            $updateSuccess = updateRequestStatus($requestId, $newStatus);
            
            if ($updateSuccess) {
                $response = ['status' => 'success', 'message' => 'Request updated successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to update Request.'];
            }
        }
        else
        {
            $response = [
                'status' => 'error', 
                'message' => 'Missing parameters.'
            ];
        }


    }

    header('Content-type: application/json');
    echo json_encode($response);