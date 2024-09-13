<?php require_once "../includes/header.php"?>

<?php 

    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

?>



<?php require_once "../includes/footer.php"?>