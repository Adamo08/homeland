<?php

    // Loging out
    session_start();
    session_unset();
    session_destroy();

    // Redirection to the index page
    header('Location: http://localhost/Homeland/');

