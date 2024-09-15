<?php 

    session_start();
    session_unset();
    session_destroy();

    // Go to login
    echo "<script> window.location.href = 'login.php' </script>";

