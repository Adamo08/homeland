<?php

    /**
     * Get a user-friendly error message for the file upload error code.
     *
     * @param int $errorCode The error code from $_FILES['avatar']['error']
     * @return string The user-friendly error message
     */
    function getFileUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded.';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload.';
            default:
                return 'Unknown file upload error.';
        }
    }

    /**
     * Handle file upload and validation.
     *
     * @param array $file The file array from $_FILES
     * @param string $username The expected username for the file
     * @param string $uploadDir The directory where the file will be uploaded
     * @return string|false The path of the uploaded file or false on failure
     */
    function handleFileUpload($file, $username, $uploadDir) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $maxFileSize = 3145728; // Maximum file size (3 MB)

        // Check if there was an error with the file upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException(getFileUploadErrorMessage($file['error']));
        }

        // Validate the file size
        if ($file['size'] > $maxFileSize) {
            throw new RuntimeException('File is too large. Maximum size is ' . $maxFileSize . ' bytes.');
        }

        // Extract file extension
        $fileName = $file['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate the file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new RuntimeException('Invalid file type. Allowed types are: ' . implode(', ', $allowedExtensions));
        }

        // Validate the file name
        $expectedFileName = $username . '.' . $fileExtension;
        if ($fileName !== $expectedFileName) {
            throw new RuntimeException('Avatar name must match the username.');
        }

        // Define the path for the uploaded file
        $uploadFile = $uploadDir . basename($expectedFileName);

        // Move the uploaded file to the desired location
        if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        return $uploadFile;
    }

    /**
     * Validate and handle the file upload.
     *
     * @param array $file The file array from $_FILES
     * @param string $username The expected username for the file
     * @return string|false The path of the uploaded file or false on failure
     */
    function uploadAvatar($file, $username) {
        $uploadDir = '../assets/uploads/avatars/';
    
        try {
            return handleFileUpload($file, $username, $uploadDir);
        } catch (RuntimeException $e) {
            // Store the error message in a session variable
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
            $_SESSION['upload_error'] = $e->getMessage();
            return false; // Return false on failure
        }
    }
