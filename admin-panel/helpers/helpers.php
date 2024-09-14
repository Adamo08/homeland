<?php 


    if (!defined('ADMINURL')){
        define('ADMINURL','http://localhost/Homeland/admin-panel/');
    }

    if (!defined('ADMINAUTH')){
        define('ADMINAUTH',ADMINURL.'auth/');
    }


    /**
     * Returns the full URL for the admin panel concatenated with the passed argument.
     *
     * @param string $path
     * @return string
     */
    function URL($path = '') {
        // Base URL of the site
        $baseURL = ADMINURL;
        
        // Remove leading and trailing slashes from the path
        $path = trim($path, '/');
        
        // Return the concatenated URL
        return $baseURL . $path;
    }

    /**
     * A function to sanitize the given input
     * 
     * @param string $data
     * @return string the sanitized input
     */
    function sanitizeInput($data) {
        return htmlspecialchars(trim($data));
    }



?>