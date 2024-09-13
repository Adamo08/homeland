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
     * Retrieve properties by property type.
     *
     * @param string $propertyType The property type to filter by (e.g., 'Home', 'Condo').
     * 
     * @return array The list of properties matching the given property type.
     */
    function getPropertiesByType($propertyType) {
        global $pdo;

        // Prepare the SQL query
        $query = "SELECT * FROM properties WHERE property_type = :propertyType";
        
        // Prepare the statement
        $stmt = $pdo->prepare($query);
        
        // Bind the parameter
        $stmt->bindParam(':propertyType', $propertyType, PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch and return the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve a property by its ID.
     *
     * @param int $propertyID The ID of the property.
     * 
     * @return array|false The property details as an associative array if found, or false if not found.
     */
    function getPropertyByID($propertyID) {
        global $pdo;

        // Prepare the SQL query to select the property by ID
        $query = "SELECT * FROM properties WHERE id = :propertyID";

        // Prepare the statement
        $stmt = $pdo->prepare($query);

        // Bind the parameter
        $stmt->bindParam(':propertyID', $propertyID, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch and return the property details as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * A function to get the associated gallery to a property 
     * @param int $propertyID
     *  @return array|false
     * 
     */
    function getPropertyGallery($propertyID) {
        global $pdo;

        // Prepare the SQL query to select the property by ID
        $query = "SELECT * FROM galleries WHERE property_id = :propertyID";

         // Prepare the statement
        $stmt = $pdo->prepare($query);

        // Bind the parameter
        $stmt->bindParam(':propertyID', $propertyID, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch and return the property details as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    /**
     * Fetch related properties based on property type OR state.
     *
     * @param string $propertyType The type of the current property (e.g., 'Home', 'Condo').
     * @param string $state The state of the current property.
     * @param int $excludePropertyId The ID of the current property to exclude it from results.
     * @param int $limit The number of related properties to fetch (optional).
     * @return array An array of related properties.
     */
    function getRelatedProperties( string $propertyType, string $state, int $excludePropertyId, int $limit = 4): array {
        
        global $pdo;

        // Fetch related properties with the same property type 
        // OR state, 
        // Excluding the current property

        $query = "SELECT * FROM properties 
                        WHERE (property_type = :propertyType OR state = :state) 
                        AND id != :excludePropertyId 
                        LIMIT :limit
                ";
        
        // Preparing the query
        $stmt = $pdo->prepare($query);

        // Binding parameters
        $stmt->bindParam(':propertyType', $propertyType, PDO::PARAM_STR);
        $stmt->bindParam(':state', $state, PDO::PARAM_STR);
        $stmt->bindParam(':excludePropertyId', $excludePropertyId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Return the result as an array of related properties
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * A function to add a property to favorites
     * @param int $userId
     * @param int $propertyId
     * 
     * @return bool
     */
    function addToFavorites($userId, $propertyId) {
        global $pdo; // Use the global $pdo from config.php
        $sql = "INSERT INTO favorites (user_id, property_id) VALUES (:user_id, :property_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * A function that removes a property from favorites
     * @param int $userId
     * @param int $propertyId
     * 
     * @return bool
     */
    function removeFromFavorites($userId, $propertyId) {
        global $pdo;
        
        // Base query
        $sql = "DELETE FROM favorites WHERE user_id = :user_id AND property_id = :property_id";
        
        // Preparing the query
        $stmt = $pdo->prepare($sql);

        // Binding Params
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $propertyId, PDO::PARAM_INT);

        // Executing
        return $stmt->execute();
    }


    /**
     * A function that checks if a property is in the favorites
     * 
     * @param int $userId
     * @param int $propertyId
     * 
     * @return bool
     * 
     */ 
    function inFavorites($userId, $propertyId) {
        global $pdo; 

        // Base query
        $sql = "SELECT COUNT(*) FROM favorites WHERE user_id = :user_id AND property_id = :property_id";
        
        // Preparing
        $stmt = $pdo->prepare($sql);

        // Binding parameters
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Check if the count is greater than 0
        $count = $stmt->fetchColumn();
        return $count > 0;
    }


    /**
     * 
     * A function that returns the list of favorites 
     * @param int $userId
     * @return array
     * 
     */
    function getFavorites($userId){
        global $pdo;

        // Base query
        $query = "SELECT f.property_id, f.created_at, p.title, p.street_address, p.status 
                    FROM favorites f
                    INNER JOIN properties p
                    ON
                        f.property_id = p.id
                    WHERE
                        f.user_id = :user_id
                    ORDER BY p.id ASC
        ";

        // Preparing the base query
        $stmt = $pdo -> prepare($query);

        // Binding params
        $stmt -> bindParam(":user_id", $userId, PDO::PARAM_INT);

        // Executing
        $stmt -> execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     *
     * A function to add a new request for a property 
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param int $userId
     * @param int $propertyId
     * 
     * @return bool
     * 
     */
    function insertRequest($name,$email,$phone,$userId,$propertyId){
        global $pdo;

        // Base query
        $query = "INSERT INTO requests(name,email,phone,user_id,property_id)
                    VALUES 
                        (
                            :name,
                            :email,
                            :phone,
                            :user_id,
                            :property_id
                        )
        ";

        // Preparing the base query
        $stmt = $pdo -> prepare($query);

        // Binding params
        $stmt -> bindParam(":name",$name,PDO::PARAM_STR);
        $stmt -> bindParam(":email",$email,PDO::PARAM_STR);
        $stmt -> bindParam(":phone",$phone,PDO::PARAM_STR);
        $stmt -> bindParam(":user_id",$userId,PDO::PARAM_INT);
        $stmt -> bindParam(":property_id",$propertyId,PDO::PARAM_INT);

        if ($stmt->execute()){
            return true;
        }

        return false;
    }


    /**
     * A function that checks if a property is in the favorites
     * 
     * @param int $userId
     * @param int $propertyId
     * 
     * @return bool
     * 
     */ 
    function inRequests($userId, $propertyId) {
        global $pdo; 

        // Base query
        $sql = "SELECT COUNT(*) FROM requests WHERE user_id = :user_id AND property_id = :property_id";
        
        // Preparing
        $stmt = $pdo->prepare($sql);

        // Binding parameters
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Check if the count is greater than 0
        $count = $stmt->fetchColumn();
        return $count > 0;
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
     * Fetches all categories from the categories table.
     *
     * @return array An associative array of categories where each category is represented as an associative array.
     */
    function getAllCategories() {
        global $pdo;

        // Base query
        $query = "SELECT * FROM categories";

        // Prepare query
        $stmt = $pdo->prepare($query);

        // Execute the query
        $stmt->execute();

        // Fetch all results as an associative array
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the categories
        return $categories;
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
