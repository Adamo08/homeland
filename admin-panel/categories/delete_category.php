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

        $id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
        
        if ($id > 0){
            // Deleting category
            $deleteSuccess = deleteCategory($id);
            
            if ($deleteSuccess) {
                $response = ['status' => 'success', 'message' => 'Category deleted successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete category.'];
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