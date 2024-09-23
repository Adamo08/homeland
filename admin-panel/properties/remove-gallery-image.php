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
        // Getting the gallery id
        $gallery_id = isset($_POST['gallery_id']) ? intval($_POST['gallery_id']) : 0;
        $gallery_name = $_POST['gallery_name'] ?? null;
        
        if($gallery_id > 0 && $gallery_name){
            $deleteSuccess = deleteGalleryPhoto($gallery_id);
            if ($deleteSuccess) {
                                // Unlink the image from galleries
                if (unlink("C:/xampp/htdocs/HomeLand/assets/uploads/properties/galleries/$gallery_name")){
                    $response = ['status' => 'success', 'message' => 'Gallery image deleted successfully'];
                }
                else{
                    $response = ['status' => 'error', 'message' => 'Failed to unlink gallery image!'];

                }
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete gallery image!'];
            }
        }
    }
    else
    {
        $response = [
            'status' => 'error', 
            'message' => 'Missing parameters.'
        ];
    }




    header('Content-type: application/json');
    echo json_encode($response);



