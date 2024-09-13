<?php 

    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

?>


<?php 

    require_once "../functions/database.php";
    require_once "../functions/helpers.php";
    require_once "../config/config.php";

    if (isset($_POST['submit'])) {
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $userId = $_POST['user_id'];
        $propertyId = $_POST['property_id'];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script> window.location.href = '".URL("property-details.php?id=$propertyId&success=0&error=invalid_email")."'; </script>";
            exit();
        }

        // Insert request
        if (insertRequest($name, $email, $phone, $userId, $propertyId)) {
            echo "<script> window.location.href = '".URL("property-details.php?id=$propertyId&success=1")."'; </script>";
            exit();
        } else {
            echo "<script> window.location.href = '".URL("property-details.php?id=$propertyId&success=0")."'; </script>";
            exit();
        }
    }
    else
        {
            echo "<script> window.location.href = '".URL()."'; </script>";
            exit();
        }

