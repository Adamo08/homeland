<?php require_once "../includes/header.php"?>

<?php

    if (isset($_POST['submit'])){

        // errors
        $errors = [];

        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $price = sanitizeInput($_POST['price']);
        $street_address = sanitizeInput($_POST['street_address']);
        $unit = sanitizeInput($_POST['unit']);
        $city = sanitizeInput($_POST['city']);
        $state = sanitizeInput($_POST['state']);
        $zip_code = sanitizeInput($_POST['zip_code']);
        $size_sqft = sanitizeInput($_POST['size_sqft']);
        $bedrooms = sanitizeInput($_POST['bedrooms']);
        $bathrooms = sanitizeInput($_POST['bathrooms']);
        $garage_spaces = sanitizeInput($_POST['garage_spaces']);
        $area = sanitizeInput($_POST['area']);
        $year_built = sanitizeInput($_POST['year_built']);
        $features = sanitizeInput($_POST['features']);
        $area = sanitizeInput($_POST['area']);
        $property_type = sanitizeInput($_POST['property_type']);
        $property_status = sanitizeInput($_POST['property_status']);

        // Validation
        if(empty($title)){
            $errors['title'] = "Title is required";
        }
        if(empty($description)){
            $errors['description'] = "Description is required";
        }
        if(empty($price)){
            $errors['price'] = "Price is required";
        }
        if(empty($street_address)){
            $errors['street_address'] = "Street Address is required";
        }
        if(empty($unit)){
            $errors['unit'] = "Unit is required";
        }
        if(empty($city)){
            $errors['city'] = "City is required";
        }
        if(empty($state)){
            $errors['state'] = "State is required";
        }
        if(empty($zip_code)){
            $errors['zip_code'] = "Zip Code is required";
        }
        if(empty($size_sqft)){
            $errors['size_sqft'] = "Size in Square Feet is required";
        }
        if(empty($bedrooms)){
            $errors['bedrooms'] = "Number of Bedrooms is required";
        }
        if(empty($bathrooms)){
            $errors['bathrooms'] = "Number of Bathrooms is required";
        }
        if(empty($garage_spaces)){
            $errors['garage_spaces'] = "Number of Garage Spaces is required";
        }
        if(empty($area)){
            $errors['area'] = "Area is required";
        }
        if(empty($year_built)){
            $errors['year_built'] = "Year Built is required";
        }
        if(empty($features)){
            $errors['features'] = "Features is required";
        }

        if (!isset($_FILES['image'])){
            $errors['image'] = "Image is required";
        }

        // If there was no errors
        if (empty($errors)) {
            // Save the data to the database
        }
        






    }

?>

<?php 
    
    // Getting all the categories
    $categories = getAllcategories();
    
?>


<main>

    <section class="container mt-3">

    <h1 class="my-4 font-weight-bold bg-primary text-white px-3 py-2 rounded-3 text-center">Add New Property</h1>
    <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item active">Properties</li>
                <a href="properties-list.php" class="btn btn-primary">View List</a>
            </ol>
    <div class="card p-4">
        <form action="" method="POST">

            <?php if(isset($success)):?>   
                <div class="alert alert-success my-2">
                    <?php echo $success ?? ''?>
                </div>
            <?php endif;?>
            <?php if(isset($error)):?>     
                <div class="alert alert-danger my-2">
                    <?php echo $error ?? ''?>
                </div>
            <?php endif;?>

            <!-- Name Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Property Name: </span>
                    <input 
                        type="text" 
                        class="form-control <?php if(isset($errors['title'])) echo 'is-invalid'?>" 
                        id="propertyTitle"
                        name="title"
                        placeholder="Enter property title" 
                        value="<?=@$_POST['title']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['title'] ?? 'Property title is required.'?>
                    </div>
                </div>
            </div>

            <!-- Description Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Description: </span>
                    <input 
                        class="form-control <?php if(isset($errors['description'])) echo 'is-invalid'?>" 
                        id="propertyDescription"
                        name="description" 
                        placeholder="Enter property description"
                        value="<?=@$_POST['description']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['description'] ?? 'Property description is required.'?>                        
                    </div>
                </div>
            </div>

            <!-- Price Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Price: </span>
                    <input 
                        type="number" 
                        step="0.01"
                        class="form-control <?php if(isset($errors['price'])) echo 'is-invalid'?>" 
                        id="propertyPrice"
                        name="price"
                        placeholder="Enter property price" 
                        value="<?=@$_POST['price']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['price'] ?? 'Property price is required.'?>
                    </div>
                </div>
            </div>

            <!-- Street Address Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Street Address: </span>
                    <input 
                        type="text" 
                        class="form-control <?php if(isset($errors['street_address'])) echo 'is-invalid'?>" 
                        id="streetAddress"
                        name="street_address"
                        placeholder="Enter street address" 
                        value="<?=@$_POST['street_address']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['street_address'] ?? ''?>
                    </div>
                </div>
            </div>

            <!-- Unit Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Unit: </span>
                    <input 
                        type="text" 
                        class="form-control <?php if(isset($errors['unit'])) echo 'is-invalid'?>" 
                        id="unit"
                        name="unit"
                        placeholder="Unit X4A" 
                        value="<?=@$_POST['unit']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['unit'] ?? 'Unit is required.'?>
                    </div>
                </div>
            </div>

            <!-- City Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">City: </span>
                    <input 
                        type="text" 
                        class="form-control <?php if(isset($errors['city'])) echo 'is-invalid'?>" 
                        id="city"
                        name="city"
                        placeholder="Enter city" 
                        value="<?=@$_POST['city']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['city'] ?? 'City is required.'?>
                    </div>
                </div>
            </div>

            <!-- State Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">State: </span>
                    <input 
                        type="text" 
                        class="form-control <?php if(isset($errors['state'])) echo 'is-invalid'?>" 
                        id="state"
                        name="state"
                        placeholder="State e.g LA" 
                        value="<?=@$_POST['state']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['state'] ?? ''?>
                    </div>
                </div>
            </div>

            <!-- Zip Code Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Zip Code: </span>
                    <input 
                        type="text" 
                        class="form-control <?php if(isset($errors['zip_code'])) echo 'is-invalid'?>" 
                        id="zipCode"
                        name="zip_code"
                        placeholder="Enter zip code" 
                        value="<?=@$_POST['zip_code']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['zip_code'] ?? ''?>
                    </div>
                </div>
            </div>

            <!-- Size (sqft) Input Group -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Size (sqft): </span>
                    <input 
                        type="number" 
                        step="0.5"
                        class="form-control <?php if(isset($errors['size_sqft'])) echo 'is-invalid'?>" 
                        id="sizeSqft"
                        name="size_sqft"
                        placeholder="Enter property size in sqft" 
                        value="<?=@$_POST['size_sqft']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['size_sqft'] ?? 'Property size is required.'?>
                    </div>
                </div>
            </div>

            <!-- Bedrooms Input -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Bedrooms: </span>
                    <input 
                        type="number" 
                        class="form-control <?php if(isset($errors['bedrooms'])) echo 'is-invalid'?>" 
                        id="bedrooms" 
                        name="bedrooms" 
                        placeholder="Enter number of bedrooms" 
                        value="<?=@$_POST['bedrooms']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['bedrooms'] ?? 'Please enter a valid number of bedrooms.'?>
                    </div>
                </div>
            </div>

            <!-- Bathrooms Input -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Bathrooms: </span>
                    <input 
                        type="number" 
                        class="form-control <?php if(isset($errors['bathrooms'])) echo 'is-invalid'?>" 
                        id="bathrooms" 
                        name="bathrooms" 
                        placeholder="Enter number of bathrooms" 
                        value="<?=@$_POST['bathrooms']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['bathrooms'] ?? 'Please enter a valid number of bathrooms.'?>
                    </div>
                </div>
            </div>

            <!-- Garage Spaces Input -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Garage Spaces: </span>
                    <input 
                        type="number" 
                        class="form-control <?php if(isset($errors['garage_spaces'])) echo 'is-invalid'?>" 
                        id="garageSpaces" 
                        name="garage_spaces" 
                        placeholder="Enter number of garage spaces" 
                        value="<?=@$_POST['garage_spaces']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['garage_spaces'] ?? 'Please enter a valid number of garage spaces.'?>
                    </div>
                </div>
            </div>

            <!-- Area Input -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Area (sq meters): </span>
                    <input 
                        type="number" 
                        step="0.01" 
                        class="form-control <?php if(isset($errors['area'])) echo 'is-invalid'?>" 
                        id="area" 
                        name="area" 
                        placeholder="Enter property area in square meters" 
                        value="<?=@$_POST['area']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['area'] ?? 'Please enter a valid area.'?>
                    </div>
                </div>
            </div>

            <!-- Year Built Input -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Year Built: </span>
                    <input 
                        type="number"
                        min="1900"
                        max="<?=date('Y')?>" 
                        class="form-control <?php if(isset($errors['year_built'])) echo 'is-invalid'?>" 
                        id="yearBuilt" 
                        name="year_built" 
                        placeholder="Enter year built" 
                        value="<?=@$_POST['year_built']?>"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['year_built'] ?? 'Please enter a valid year.'?>
                    </div>
                </div>
            </div>

            <!-- Features Input -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Features: </span>
                    <input 
                        class="form-control <?php if(isset($errors['features'])) echo 'is-invalid'?>" 
                        id="features" 
                        name="features" 
                        value="<?=@$_POST['features']?>"
                        placeholder="Enter property features"
                    >
                    <div class="invalid-feedback">
                        <?php echo $errors['features'] ?? 'Please enter property features.'?>
                    </div>
                </div>
            </div>


            <!-- Property Type Select -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Property Type: </span>
                    <select 
                        class="form-control <?php if(isset($errors['property_type'])) echo 'is-invalid'?>" 
                        id="propertyType" 
                        name="property_type" 
                        required
                    >
                        <option value="" disabled selected>Select an option</option>
                        <?php foreach($categories as $category):?>
                            <option 
                                value="<?php echo htmlspecialchars($category['name']);?>" 
                                <?php if (@$_POST['property_type'] === $category['name']) echo 'selected'?>
                            >
                                <?php echo $category['name'];?>
                            </option>
                        <?php endforeach?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $errors['property_type'] ?? 'Please select a property type.'?>
                    </div>
                </div>
            </div>

            <!-- Property Status Select -->
            <div class="mb-3 form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text">Property For: </span>
                    <select 
                        class="form-control <?php if(isset($errors['property_status'])) echo 'is-invalid'?>" 
                        id="propertyStatus" 
                        name="property_status"
                        required 
                    >
                        <option value="" disabled selected>Select an option</option>
                        <option value="For Sale <?php if (@$_POST['offer-types'] === 'For Sale') echo 'selected';?>">For Sale</option>
                        <option value="For Rent" <?php if (@$_POST['offer-types'] === 'For Rent') echo 'selected';?>>For Rent</option>
                        <option value="For Lease" <?php if (@$_POST['offer-types'] === 'For Lease') echo 'selected';?>>For Lease</option>
                        <option value="For Rent or Sale" <?php if (@$_POST['offer-types'] === 'For Rent or Sale') echo 'selected';?>>For Rent or Sale</option>
                        <option value="For Rent or Lease" <?php if (@$_POST['offer-types'] === 'For Rent or Lease') echo 'selected';?>>For Rent or Lease</option>
                        <option value="For Sale or Lease" <?php if (@$_POST['offer-types'] === 'For Sale or Lease') echo 'selected';?>>For Sale or Lease</option>
                        <option value="For Rent, Sale, or Lease" <?php if (@$_POST['offer-types'] === 'For Rent, Sale, or Lease') echo 'selected';?>>For Rent, Sale, or Lease</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $errors['property_status'] ?? 'Please select a property status.'?>
                    </div>
                </div>
            </div>

            <!-- Property Image -->
            <div class="input-group has-validation mb-3">
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>"
                    accept="image/jpeg"    
                >
                <div class="invalid-feedback">
                    <?php echo $errors['image'] ?? 'Please select an image.'?>
                </div>
            </div>


            <!-- Submit Button -->
            <button class="btn btn-primary" type="submit" name="submit">Add Property</button>
        </form>
    </div>

    </section>
</main>


<?php require_once "../includes/footer.php"?>
