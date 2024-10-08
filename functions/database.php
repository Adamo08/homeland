<?php require_once "C:/xampp/htdocs/Homeland/config/config.php"?>
<?php



    /*******************************************************/
    /*************   Usres               *******************/
    /*******************************************************/



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
     * A function for inserting user details
     * @param int $user_id
     * @param string $job
     * @param string $facebook facebook link
     * @param string $instagram instagram link
     * @param string $twitter twitter link
     * @param string $github github link
     * 
     * @return bool
     */
    function insertUserDetails($user_id, $job, $facebook, $instagram, $twitter, $github){
        global $pdo;

        // Base query
        $sql = "INSERT INTO user_details (user_id,job, facebook, instagram, twitter, github)
                VALUES 
                        (
                            :user_id,
                            :job,
                            :facebook,
                            :instagram,
                            :twitter,
                            :github
                        )
        ";

        // Preparing
        $stmt = $pdo->prepare($sql);

        // Binding
        $stmt->bindParam(':job', $job,PDO::PARAM_STR);
        $stmt->bindParam(':facebook', $facebook,PDO::PARAM_STR);
        $stmt->bindParam(':instagram', $instagram,PDO::PARAM_STR);
        $stmt->bindParam(':twitter', $twitter,PDO::PARAM_STR);
        $stmt->bindParam(':github', $github,PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id,PDO::PARAM_INT);

        // Execute and return
        return $stmt -> execute();

    }

    /**
     * A function to get a user details (additional info)
     * @param int $userId
     * @return array
     * 
     */
    function getUserDetail($userId){
        
        global $pdo;
        
        // Base query
        $sql = "SELECT * FROM user_details WHERE user_id = :user_id";

        // Preparing
        $stmt = $pdo->prepare($sql);

        // Binding
        $stmt -> bindParam(":user_id", $userId, PDO::PARAM_INT);
        
        // Executing
        $stmt -> execute();

        return $stmt -> fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * A function that updates the user Info 
     * @param int $userId
     * @param string $full_name
     * @param string $username
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $job
     * 
     * @return bool
     */
    function updateUser($userId, $full_name, $username, $email, $phone, $address,$job){
        global $pdo;

        // Base query
        $sql = "UPDATE users u
                JOIN user_details ud ON
                        u.id = ud.user_id
                SET
                    u.full_name = :full_name,
                    u.username = :username,
                    u.email = :email,
                    u.phone = :phone,
                    u.address = :address,
                    ud.job = :job
                WHERE
                    u.id = :user_id
        ";

        // Preparing
        $stmt = $pdo -> prepare($sql);

        // Binding
        $stmt -> bindParam(':full_name',$full_name,PDO::PARAM_STR);
        $stmt -> bindParam(':username',$username,PDO::PARAM_STR);
        $stmt -> bindParam(':email',$email,PDO::PARAM_STR);
        $stmt -> bindParam(':phone',$phone,PDO::PARAM_STR);
        $stmt -> bindParam(':address',$address,PDO::PARAM_STR);
        $stmt -> bindParam(':job',$job,PDO::PARAM_STR);
        $stmt -> bindParam(':user_id',$userId,PDO::PARAM_INT);


        // Executing and return
        return $stmt -> execute();
    }

    /**
     * A function to update a social link 
     * 
     * @param int $userId
     * @param string $social
     * @param string $newUrl
     * 
     * @return bool
     */

    function updateSocialLink($userId, $social, $newUrl) {
        global $pdo;
    
        $sql = "UPDATE user_details 
                SET {$social} = :new_url 
                WHERE user_id = :user_id";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':new_url', $newUrl, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }


    /**
     * A function to update a social link 
     * 
     * @param int $userId
     * @param string $social
     * 
     * @return bool
     */

    function removeSocialLink($userId, $social) {
        global $pdo;
    
        $sql = "UPDATE user_details 
                SET {$social} = NULL 
                WHERE user_id = :user_id";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    /**
     * A functions that returns the number of rows in a given table
     * 
     * @param string $table
     * @return mixed
     */


    /**
     * A function that gets a user ID by the given email @
     * @param string $email
     * 
     * @return mixed
     */
    function getUserIDByEmail($email) {
        global $pdo;
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['id'];
    }


    /**
     * A function to get a user from the database 
     * 
     * @return array
     */
    function getUsers() {
        global $pdo;
        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    /**
     * A function to get a user from db 
     * @param string $email
     * @param string $passord
     * @return array
     */
    function getUserByEmailAndPassword($email, $password) {
        global $pdo;
        $query = "SELECT * FROM users WHERE (email = :email OR username = :email) AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /*******************************************************/
    /*************   Admins               ******************/
    /*******************************************************/


    /**
     * A function to get all the admins from db 
     * @param int $id
     * 
     * @return array
     */
    function getAdmins() {
        global $pdo;

        // Base query
        $query = "SELECT * FROM admins";
        
        // Preparing
        $stmt = $pdo->prepare($query);


        // Executing
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * A function to get an admin from db by his id
     * @param int $id
     * 
     * @return array
     */
    function getAdmin($id) {
        global $pdo;

        // Base query
        $query = "SELECT * FROM admins WHERE id = :id";
        
        // Preparing
        $stmt = $pdo->prepare($query);

        // Binding
        $stmt->bindParam(':id', $id);

        // Executing
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * A function to get an admin from db by his username && email
     * @param int $username
     * @param int $email
     * 
     * @return array
     */
    function getAdminByEmailAndUsername($username, $email) {
        global $pdo;

        // Base query
        $query = "SELECT * FROM admins WHERE username = :username OR email = :email";
        
        // Preparing
        $stmt = $pdo->prepare($query);

        // Binding
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        
        // Executing
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * A function that creates new admin with the passed data
     * @param string $full_name
     * @param string $username
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $password
     * @param string $avatar
     * 
     * @return bool
     */
    function createAdmin($full_name, $username, $email, $phone,$address, $password, $avatar){
        global $pdo;
        // Base query
        $query = "INSERT INTO admins (full_name, username, email, phone,address, password, image)
                    VALUES
                        (
                            :full_name,
                            :username,
                            :email,
                            :phone,
                            :address,
                            :password,
                            :avatar
                        )
        ";

        // Preparing
        $stmt = $pdo->prepare($query);

        // Binding
        $stmt->bindParam(':full_name', $full_name,PDO::PARAM_STR);
        $stmt->bindParam(":username",$username,PDO::PARAM_STR);
        $stmt->bindParam(':email', $email,PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone,PDO::PARAM_STR);
        $stmt->bindParam(':address', $address,PDO::PARAM_STR);
        $stmt->bindParam(':password', $password,PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar,PDO::PARAM_STR);

        // Exectuting & Return
        return $stmt -> execute();
    }

    /**
     * A function to get an admin from db 
     * @param string $email
     * @param string $passord
     * @return array
     */
    function getAdminByEmailAndPassword($email, $password) {
        global $pdo;

        // Base query
        $query = "SELECT * FROM admins WHERE (email = :email) AND password = :password";
        
        // Preparing
        $stmt = $pdo->prepare($query);

        // Binding
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Executing
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * A function that return the admin username 
     * @param int $id
     * 
     * @return string
     */
    function getAdminUsername($id) {
        global $pdo;

        // Base query
        $query = "SELECT username FROM admins WHERE id = :id";

        // Preparing
        $stmt = $pdo->prepare($query);
        
        // Binding
        $stmt->bindParam(':id', $id);

        // Executing
        $stmt->execute();
        return $stmt->fetchColumn();

    }

    /**
     * A function to update admin info
     * @param int $adminId
     * @param string $full_name
     * @param string $email
     * @param string $phone
     * @param string $address
     * 
     * @return bool
     */
    function updateAdminInfo($adminId, $full_name, $email, $phone, $address) {
        global $pdo;
    
        // Start building the base query
        $sql = "UPDATE admins SET ";
        $params = [];
    
        // Check each parameter and build the query accordingly
        if (!is_null($full_name)) {
            $sql .= "full_name = :full_name, ";
            $params[':full_name'] = $full_name;
        }
        if (!is_null($email)) {
            $sql .= "email = :email, ";
            $params[':email'] = $email;
        }
        if (!is_null($phone)) {
            $sql .= "phone = :phone, ";
            $params[':phone'] = $phone;
        }
        if (!is_null($address)) {
            $sql .= "address = :address, ";
            $params[':address'] = $address;
        }
    
        // Remove the last comma and add the WHERE clause
        $sql = rtrim($sql, ', ') . " WHERE id = :admin_id";
        $params[':admin_id'] = $adminId;
    
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            return false; // Return false if there's an error
        }
    }
    
    
    
    
    function getRowCout($table){
        global $pdo;

        try {    
            // Base query
            $sql = "SELECT COUNT(*) FROM $table";

            // Preparing
            $stmt = $pdo -> prepare($sql);
            
            // Executing
            $stmt -> execute();
            
            return $stmt -> fetchColumn();
        } 
        catch(PDOException $e){
            echo "Error: ".$e->getMessage();
            return false;
        }
    }
    
    /*******************************************************/
    /*************   Properties          *******************/
    /*******************************************************/


    /**
     * Insert a new property into the database.
     *
     * @param string $title The property title.
     * @param string $description The property description.
     * @param float $price The property price.
     * @param string $street_address The street address.
     * @param string $unit The unit identifier.
     * @param string $city The city.
     * @param string $state The state.
     * @param string $zip_code The zip code.
     * @param float $size_sqft The size in square feet.
     * @param int $bedrooms Number of bedrooms.
     * @param int $bathrooms Number of bathrooms.
     * @param int $garage_spaces Number of garage spaces.
     * @param float $area The area in square meters.
     * @param int $year_built The year the property was built.
     * @param string $features The features of the property.
     * @param string $property_type The type of the property.
     * @param string $property_status The status (for sale, rent, lease, etc.).
     * @param string $image The image file path.
     * @param int $admin_id The admin added the property.
     * 
     * @return bool Returns true on success, false on failure.
     */
    function insertProperty($title, $description, $price, $street_address, $unit, $city, $state, $zip_code, $size_sqft, $bedrooms, $bathrooms, $garage_spaces, $area, $year_built, $features, $property_type, $property_status, $image, $admin_id)
    {
        global $pdo; // Make sure $pdo is initialized
        $price_sqft = $price / $size_sqft;

        try {
            $sql = "INSERT INTO properties (title, description, price, street_address, unit, city, state, zip_code, size_sqft, price_sqft, bedrooms, bathrooms, garage_spaces, area, year_built, features, property_type, property_status, image, admin_id)
                    VALUES (:title, :description, :price, :street_address, :unit, :city, :state, :zip_code, :size_sqft, :price_sqft, :bedrooms, :bathrooms, :garage_spaces, :area, :year_built, :features, :property_type, :property_status, :image, :admin_id)";
            if(incrementPropertyCount($property_type)){
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':street_address', $street_address);
                $stmt->bindParam(':unit', $unit);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':state', $state);
                $stmt->bindParam(':zip_code', $zip_code);
                $stmt->bindParam(':size_sqft', $size_sqft);
                $stmt->bindParam(':price_sqft', $price_sqft);
                $stmt->bindParam(':bedrooms', $bedrooms);
                $stmt->bindParam(':bathrooms', $bathrooms);
                $stmt->bindParam(':garage_spaces', $garage_spaces);
                $stmt->bindParam(':area', $area);
                $stmt->bindParam(':year_built', $year_built);
                $stmt->bindParam(':features', $features);
                $stmt->bindParam(':property_type', $property_type);
                $stmt->bindParam(':property_status', $property_status);
                $stmt->bindParam(':image', $image);
                $stmt->bindParam(':admin_id', $admin_id);

                return $stmt->execute(); // Returns true on success, false on failure
            }
            else{
                return false;
            }
        } catch (PDOException $e) {
            // Log the error or display a friendly message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * A function that's takes an id as parameter and deletes the property with the passed id
     * @param int $id
     * @return bool
     * 
     */
    function deleteProperty($id){
        global $pdo;

        // Base Query
        $sql = "DELETE FROM properties WHERE id = :id";

        // Preparing & Binding
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);



        return $stmt -> execute();
    }


    /**
     * A funcion that indicates if a property exists in the db OR not
     * @param int $title
     * @return bool
     */


    function propertyExists($title) {
        
        global $pdo;
    
        // Base query
        $sql = "SELECT COUNT(*) FROM properties WHERE title = :title";
    
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
    
        // Binding
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    
        // Execute the statement
        $stmt->execute();
    
        $count = $stmt->fetchColumn();
    
        return $count > 0;
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
     * A function that insert new images to the gallery
     * @param int $property_id
     * @param string $image_url
     * 
     * @return bool
     */
    function insertGalleryImage($property_id, $image_url) {

        global $pdo;
        try{
            // Base query
            $query = "INSERT INTO galleries (property_id, image_url) 
                        VALUES (
                                :property_id, 
                                :image_url
                                )
            ";
            // Prepare the statement
            $stmt = $pdo->prepare($query);
            // Bind the parameters
            $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
            $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);

            return $stmt -> execute();
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * A function that deletes gallery items
     * @param int $gallery_id
     * @return bool
     */
    function deleteGalleryPhoto($gallery_id){
        global $pdo;

        try{
            // Base query
            $sql = "DELETE FROM galleries WHERE id = :gallery_id";
            // Preparing
            $stmt = $pdo -> prepare($sql);
            // Binding
            $stmt -> bindParam(":gallery_id", $gallery_id, PDO::PARAM_INT);

            return $stmt -> execute();
        }
        catch (PDOException $e){
            echo "Error: ". $e->getMessage();
            return false;
        }
        
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



    /*******************************************************/
    /*************   Favorites          ********************/
    /*******************************************************/


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



    /*******************************************************/
    /*************   Requests               ****************/
    /*******************************************************/


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
     * A function that removes a property from favorites
     * @param int $requestId
     * 
     * @return bool
     */
    function removeFromRequests($requestId) {
        global $pdo;
        
        // Base query
        $sql = "DELETE FROM requests WHERE id = :request_id";
        
        // Preparing the query
        $stmt = $pdo->prepare($sql);

        // Binding Param
        $stmt->bindParam(':request_id', $requestId, PDO::PARAM_INT);

        // Executing
        return $stmt->execute();
    }


    /**
     * 
     * A function that returns the list of requests 
     * @return array
     * 
     */
    function getAllRequests(){
        global $pdo;

        // Base query
        $query = "SELECT r.id, r.property_id, r.user_id, r.status as request_status, r.created_at, p.title, p.street_address, p.status
                    FROM requests r
                    INNER JOIN properties p
                    ON
                        r.property_id = p.id
                    ORDER BY p.id ASC
        ";

        // Preparing the base query
        $stmt = $pdo -> prepare($query);

        // Executing
        $stmt -> execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * A function that returns the list of requests 
     * @param int $userId
     * @return array
     * 
     */
    function getUserRequests($userId){
        global $pdo;

        // Base query
        $query = "SELECT r.id, r.property_id, r.status ,r.created_at, p.title, p.street_address
                    FROM requests r
                    INNER JOIN properties p
                    ON
                        r.property_id = p.id
                    WHERE
                        r.user_id = :user_id
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
     * A function that updates the status of the passed request (id)
     * @param int $requestId
     * @param string $newStatus
     * 
     * @return bool
     */
    function updateRequestStatus($requestId, $newStatus) {
        global $pdo;

        try{
            // Base query
            $sql = "UPDATE requests SET status = :status WHERE id = :id";
            // Preparing the statement
            $stmt = $pdo->prepare($sql);
            // Binding params
            $stmt->bindParam(':id', $requestId, PDO::PARAM_INT);
            $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);

            // Execute and return
            return $stmt->execute();
        }
        catch(PDOException $e){
            echo "Error updating request status: " . $e->getMessage();
            return false;
        }

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

    /*******************************************************/
    /*************   Categories               ****************/
    /*******************************************************/


    /**
     * A function to insert new categories
     * @param string $name
     * @param string $description
     * 
     * @return bool
     */
    function insertCategory($name, $description) {
        global $pdo;
        
        try{
            // Base query
            $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
            // Preparing
            $stmt = $pdo->prepare($query);
            // Binding
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            // Executing & return
            return $stmt->execute();
        }
        catch(PDOException $e){
            echo "Error: ".$e->getMessage();
            return false;
        }

    }

    /**
     * Fetches all categories from the categories table.
     * @param bool $isActive
     * @return array An associative array of categories where each category is represented as an associative array.
     */
    function getAllCategories($isActive = false) {
        global $pdo;

        // Base query
        $query = "SELECT * FROM categories WHERE 1=1";

        if ($isActive){
            $query .= " AND property_count != 0";
        }

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
     * A function to update a category
     * @param int $id
     * @param string $name
     * @param string $description
     * 
     * @return bool
     */
    function updateCategory($id, $name, $description){
        global $pdo;

        // Base query
        $sql = "UPDATE categories
                SET
                    name = :name,
                    description = :description

                WHERE
                    id = :id
        ";
        // Preparing
        $stmt = $pdo -> prepare($sql);

        // Binding
        $stmt -> bindParam(":name",$name,PDO::PARAM_STR);
        $stmt -> bindParam(":description",$description,PDO::PARAM_STR);
        $stmt -> bindParam("id",$id,PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * A function that's takes an id as parameter and deletes the category with the passed id
     * @param int $id
     * @return bool
     * 
     */
    function deleteCategory($id){
        global $pdo;

        // Base Query
        $sql = "DELETE FROM categories WHERE id = :id";

        // Preparing & Binding
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);



        return $stmt -> execute();
    }

    /**
     * A function that increment the property_count of a given category
     * @param string $name
     * 
     * @return bool
     */
    function  incrementPropertyCount($name){
        global $pdo;
        
        // Base query
        $sql = "UPDATE categories 
                SET 
                    property_count = property_count + 1
                WHERE
                    name = :name
        ";

        // Preparing
        $stmt = $pdo -> prepare($sql);

        // Binding
        $stmt -> bindParam(":name", $name, PDO::PARAM_STR);

        return $stmt -> execute();
    }








?>
