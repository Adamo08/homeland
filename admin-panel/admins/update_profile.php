<?php
    include "../helpers/helpers.php";
    include "../../functions/database.php";

    session_start();
    if (!isset($_SESSION['admin_id'])) {
        echo "<script> window.location.href = '" . ADMINAUTH . "login.php' </script>";
        exit();
    }

    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['admin_id']) ? intval($_POST['admin_id']) : 0;
        $full_name = isset($_POST['full_name']) ? sanitizeInput($_POST['full_name']) : null;
        $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : null;
        $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : null;
        $address = isset($_POST['address']) ? sanitizeInput($_POST['address']) : null;

        if ($id > 0) {
            $updateSuccess = updateAdminInfo($id, $full_name, $email, $phone, $address);
            if ($updateSuccess) {
                $response['status'] = 'success';
                $response['message'] = 'Admin info updated successfully';
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to update info.'];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Missing parameters.'
            ];
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);

