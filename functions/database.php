<?php require_once "C:/xampp/htdocs/Homeland/config/config.php"?>
<?php 


    /**
     * A function to get a user from the database 
     * @param string $username
     * @param string $email
     * 
     * @return mixed
     */
    function getUser($username, $email) {
        global $pdo;
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    /**
     * A function to get a user from db 
     * @param string $email
     * @param string $passord
     * @return mixed
     */
    function getUserByEmailAndPassword($email, $password) {
        global $pdo;
        $query = "SELECT * FROM users WHERE (email = :email OR username= :email) AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * A function to create a new user 
     * @param string $full_name
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $phone
     * @param string $address
     * @param string $avatar
     * @return mixed
     */
    function createUser($full_name, $username, $email, $password, $phone, $address, $avatar){
        
        global $pdo;

        try {
            // Prepare SQL statement to insert the new user
            $sql = "INSERT INTO users (full_name, username, email, password, phone, address, avatar)
                    VALUES (:full_name, :username, :email, :password, :phone, :address, :avatar)";
    
            $stmt = $pdo->prepare($sql);
    
            // Bind parameters to the SQL statement
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // Ensure password is hashed before this step
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':avatar', $avatar);
    
            // Execute the statement
            $stmt->execute();
    
            
            return true;
        } catch (PDOException $e) {
            // Log or display the error message
            echo 'Error: ' . $e->getMessage();
            return false; // Indicate failure
        }
    }


    /**
     * A function that gets all the properties from the database
     * @param int|null $limit
     * @return array
     */
    function getAllProperties($limit = null) {
        global $pdo;
        try {
            // Base query
            $query = "SELECT * FROM properties";

            // Add LIMIT clause if $limit is provided
            if ($limit !== null && $limit > 0) {
                $query .= " LIMIT :limit";
            }
            
            // Preparing the query
            $stmt = $pdo->prepare($query);

            // Bind the limit parameter if it is used
            if ($limit !== null && $limit > 0) {
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            }

            // Executing
            $stmt->execute();

            // Result 
            $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $properties;
        } catch (PDOException $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return [];
        }
    }


    /**
     * 
     * A function that searches the database based on the form inputs
     * @param string $listingType
     * @param string $offerType
     * @param string $city
     * 
     * @return array 
     */
    function searchProperties($listingType, $offerType, $city) {
        global $pdo;
    
        // Build the base query
        $query = "SELECT * FROM properties WHERE 1=1";  // 1=1 makes appending conditions easier
    
        // Add conditions based on user input
        if (!empty($listingType)) {
            $query .= " AND property_type = :listingType";
        }
        if (!empty($offerType)) {
            $query .= " AND property_status = :offerType";
        }
        if (!empty($city)) {
            $query .= " AND city = :city";
        }
    
        $stmt = $pdo->prepare($query);
    
        // Bind parameters if they are set
        if (!empty($listingType)) {
            $stmt->bindParam(':listingType', $listingType);
        }
        if (!empty($offerType)) {
            $stmt->bindParam(':offerType', $offerType);
        }
        if (!empty($city)) {
            $stmt->bindParam(':city', $city);
        }
    
        // Execute the query
        $stmt->execute();
    
        // Return the matching properties
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Search properties based on the listing_type parameter only.
     *
     * @param string $listingType
     * @return array
    */ 
    function searchPropertiesByofferType($offerType) {
        global $pdo;
        
        // Build the base query
        $query = "SELECT * FROM properties";  // 1=1 makes appending conditions easier

        // Add condition based on offerType
        if (!empty($offerType)) {
            $query .= " WHERE property_status = :offerType"; // Ensure this column name matches the database schema
        }
        

        $stmt = $pdo->prepare($query);

        // Bind parameter if it's set
        if (!empty($offerType)) {
            $stmt->bindParam(':offerType', $offerType);
        }
        
        // Execute the query
        $stmt->execute();
        
        // Return the matching properties
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    



    /**
     * A function that returns all the disponible cities (distinct) 
     * @param none
     * @return array
     *  
     */
    function getAllCities() {
        global $pdo;
        try {
            // Base query
            $query = "SELECT DISTINCT city FROM properties";

            // Preparing the query
            $stmt = $pdo->prepare($query);

            // Executing
            $stmt->execute();

            // Result 
            $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $cities;
        }catch(PDOException $e){
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return [];
        }
    }






    /**
     * Sorts an array of properties based on the specified field and order.
     *
     * @param array $properties The array of properties to sort.
     * @param string $order The sorting order ('asc' for ascending, 'desc' for descending).
     * 
     * @return array The sorted array of properties.
     */
    // Function to sort properties by price
    function sortProperties($properties, $order = 'asc') {
        usort($properties, function($a, $b) use ($order) {
            return $order === 'asc' ? $a['price'] <=> $b['price'] : $b['price'] <=> $a['price'];
        });
        return $properties;
    }





?>
