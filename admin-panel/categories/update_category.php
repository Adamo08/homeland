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
        $name = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
        $description = isset($_POST['category_description']) ? trim($_POST['category_description']) : '';

        if ($id>0 && !empty($name) && !empty($description)){
            // Updating category
            $updateSuccess = updateCategory($id, $name, $description);
            
            if ($updateSuccess) {
                $response = ['status' => 'success', 'message' => 'Category updated successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to update category.'];
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