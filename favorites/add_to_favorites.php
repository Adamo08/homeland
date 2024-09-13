<?php 

    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

?>


<?php
        require_once '../functions/database.php';

        // Check if data is posted
        if (isset($_POST['property_id']) && isset($_POST['user_id'])) {
            $propertyId = $_POST['property_id'];
            $userId = $_POST['user_id'];

            try {
                // Call the function to add to favorites
                if (addToFavorites($userId, $propertyId)) {
                    $response = ['status' => 'success', 'message' => 'Property added to favorites'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to add property to favorites'];
                }
            } catch (Exception $e) {
                $response = ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Required data is missing'];
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
