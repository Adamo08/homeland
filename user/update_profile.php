
<?php

    require_once "../config/config.php";
    require_once "../functions/database.php";
    require_once "../functions/helpers.php";


    session_start();
    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }



    // full_name
    // username
    // email
    // phone
    // address
    // job


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $full_name = sanitizeInput($_POST['full_name']);
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $address = sanitizeInput($_POST['address']);
        $job = sanitizeInput($_POST['job']);

        $userId = $_POST['user_id'];

        $emptyFields = [];

        if (empty($full_name)){
            $emptyFields ['full_name'] = true;
        }
        if (empty($username)){
            $emptyFields ['username'] = true;
        }
        if (empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emptyFields ['email'] = true;
        }
        if (empty($phone)){
            $emptyFields ['phone'] = true;
        }
        if (empty($address)){
            $emptyFields ['address'] = true;
        }
        if (empty($job)){
            $emptyFields ['job'] = true;
        }

        if (empty($emptyFields)){
            // Updating
            if (
                    updateUser(
                        $userId,
                    $full_name,
                    $username,
                        $email,
                        $phone,
                    $address,
                        $job
                    )
                )
            {
                $response = [
                    'status' => 'success', 
                    'message' => 'Info Updated Successfully!', 
                    'empty_fields' => []
                ];
            }
            else
            {
                // database error
                $response = [
                    'status' => 'error', 
                    'message' => 'Failed to update info', 
                    'empty_fields' => []
                ];
            }
        }
        else 
        {
            $response = [
                'status' => 'error', 
                'message' => 'All fields are required!', 
                'empty_fields' => $emptyFields
            ];
        }
        

    }
    else {
        $response = [
            'status' => 'error', 
            'message' => 'Invalid request',
            'empty_fields' => []
        ];
    }



    header('Content-type: application/json');
    echo json_encode($response);

