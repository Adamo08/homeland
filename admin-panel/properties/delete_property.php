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

        $id = isset($_POST['property_id']) ? intval($_POST['property_id']) : 0;
        
        if ($id > 0){
            // Deleting Property
            $deleteSuccess = deleteProperty($id);
            
            if ($deleteSuccess) {
                $response = ['status' => 'success', 'message' => 'Property deleted successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete Property.'];
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