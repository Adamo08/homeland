<?php
    /**
     * Returns the full URL for the site concatenated with the passed argument.
     *
     * @param string $path The path to concatenate with the base URL.
     * @return string The full URL.
     */
    function URL($path = '') {
        // Base URL of the site
        $baseURL = 'http://localhost/Homeland/';
        
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


    /**
 * Display an array of error messages as Bootstrap alert divs.
 *
 * @param array $errors Array of error messages to display
 * @return void
 */
    function displayErrors($errors) {
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo htmlspecialchars($error);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
    }

