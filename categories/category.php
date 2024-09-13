    <?php require_once "../includes/header.php"?>

    <?php 

        if (isset($_GET['type'])){


            $propertyType = $_GET['type'] ?? '';
            // Getting all the properties belonging to propertyType
            $properties = getPropertiesByType($propertyType);

            // Getting the disponible cities
            $cities = getAllCities();

            // Handling the searching form
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){
            
                // Get the selected values from the form
                $listingType = $propertyType;
                $offerType = $_POST['offer-types'];
                $city = $_POST['select-city'];
        
                // Debugging
                // var_dump($listingType, $offerType, $city);
        
                // Call a function to get properties based on these search parameters
                $properties = searchProperties($listingType, $offerType, $city);
        
            }

            // Handle Sort form submission
            if (isset($_POST['sortBy'])) {
                $sortOrder = $_POST['sort'] ?? 'asc'; // Default to ascending if not set


                // Sort properties based on selected order
                if ($sortOrder) {
                    $properties = sortProperties($properties, $sortOrder);
                }
            }

        }
        else{
            // Redirect To home page
            echo "<script> window.location.href = '".URL('404.php')."' </script>";
            exit();
        }
    
    ?>


    <div class="slide-one-item home-slider owl-carousel">

    <?php foreach($properties as $prop): ?>
        <div class="site-blocks-cover overlay" style="background-image: url(../assets/uploads/properties/images/<?=$prop['image']?>);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
                <span class="d-inline-block bg-success text-white px-3 mb-3 property-offer-type rounded">
                <?=$prop['property_status']?>
                </span>
                <h1 class="mb-2">
                <?=$prop['street_address']?>
                </h1>
                <p class="mb-5"><strong class="h2 text-success font-weight-bold">
                $<?=$prop['price']?>
                </strong></p>
                <p>
                <a 
                    href="<?php echo URL("property-details.php?id=$prop[id]")?>" 
                    class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2"
                >
                    See Details
                </a>
                </p>
            </div>
            </div>
        </div>
        </div>  
    <?php endforeach;?>

    </div>


    <div class="site-section site-section-sm pb-0">
        <div class="container">

            <div class="row">
                <form class="form-search col-md-12" method="POST" style="margin-top: -100px;">
                    <div class="row  align-items-end">
                        <div class="col-md-3">
                        <label for="list-types">Listing Types</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="list-types" id="list-types" class="form-control d-block rounded-0">
                                <option value="<?php echo $propertyType?>" selected>
                                    <?php echo $propertyType?>
                                </option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                            <label for="offer-types">Offer Type</label>
                            <div class="select-wrap">
                                <span class="icon icon-arrow_drop_down"></span>
                                <select name="offer-types" id="offer-types" class="form-control d-block rounded-0">
                                    <option value="">All</option>
                                    <option value="For Sale <?php if (@$_POST['offer-types'] === 'For Sale') echo 'selected';?>">For Sale</option>
                                    <option value="For Rent" <?php if (@$_POST['offer-types'] === 'For Rent') echo 'selected';?>>For Rent</option>
                                    <option value="For Lease" <?php if (@$_POST['offer-types'] === 'For Lease') echo 'selected';?>>For Lease</option>
                                    <option value="For Rent or Sale" <?php if (@$_POST['offer-types'] === 'For Rent or Sale') echo 'selected';?>>For Rent or Sale</option>
                                    <option value="For Rent or Lease" <?php if (@$_POST['offer-types'] === 'For Rent or Lease') echo 'selected';?>>For Rent or Lease</option>
                                    <option value="For Sale or Lease" <?php if (@$_POST['offer-types'] === 'For Sale or Lease') echo 'selected';?>>For Sale or Lease</option>
                                    <option value="For Rent, Sale, or Lease" <?php if (@$_POST['offer-types'] === 'For Rent, Sale, or Lease') echo 'selected';?>>For Rent, Sale, or Lease</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <label for="select-city">Select City</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="select-city" id="select-city" class="form-control d-block rounded-0">
                            <option value="">All</option>
                                <?php foreach($cities as $city): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($city['city']); ?>"
                                        <?php if(@$_POST['select-city'] === $city['city']) echo 'selected'?>
                                    >
                                    <?php echo htmlspecialchars($city['city']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <input type="submit" name="search" class="btn btn-success text-white btn-block rounded-0" value="Search">
                        </div>
                    </div>
                </form>
            </div>  

            <div class="row">
                <div class="col-md-12">
                <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">

                    <div class="mr-auto">
                        <a href="index.php" class="icon-view view-module active"><span class="icon-view_module"></span></a>
                        <a href="view-list.php" class="icon-view view-list"><span class="icon-view_list"></span></a>
                    </div>

                    
                    <form method="POST" action="">
                    <div class="d-flex"> 
                        <div class="select-wrap">
                            <!-- <span class="icon icon-arrow_drop_down"></span> -->
                            <select name="sort" class="form-control form-control-sm d-block rounded-0">
                                <option value="">Sort by</option>
                                <option value="asc" <?php if(@$_POST['sort'] === 'asc') echo 'selected'?>>Price Ascending</option>
                                <option value="desc" <?php if(@$_POST['sort'] === 'desc') echo 'selected'?>>Price Descending</option>
                            </select>
                        </div>
                        <input type="submit" class="btn-primary" name="sortBy" value="Sort">
                    </div>
                    </form>



                </div>
                </div>
            </div>

        </div>
    </div>

    <div class="site-section site-section-sm bg-light">
    <div class="container">

    <div class="row mb-5">

        <?php if (empty($properties)): ?>

            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                No properties found matching your criteria.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>

        <?php else: ?>

            <?php foreach($properties as $prop): ?>
                <?php 
                $status = $prop['property_status'];
                ?>

                <div class="col-md-6 col-lg-4 mb-4">
                <div class="property-entry h-100">
                    <a 
                    href="<?php echo URL("property-details.php?id=$prop[id]")?>" 
                    class="property-thumbnail text-decoration-none"
                    >
                    <div class="offer-type-wrap">
                        <span class="offer-type bg-success text-white">
                        <?=$prop['property_status']?>
                        </span>
                    </div>
                    <img src="../assets/uploads/properties/images/<?=$prop['image']?>" alt="Image" class="img-fluid">
                    </a>
                    <div class="p-4 property-body">
                    <!-- <a href="#" class="property-favorite text-decoration-none"><span class="icon-heart-o"></span></a> -->
                    <h2 class="property-title">
                        <a href="<?php echo URL("property-details.php?id=$prop[id]")?>"
                        >
                        <?=$prop['street_address']?>
                        </a>
                    </h2>
                    <span class="property-location d-block mb-3">
                        <span class="property-icon icon-room"></span> 
                        <?=$prop['street_address']?>
                        <?=$prop['unit']?>
                        <?=$prop['city']?>, 
                        <?=$prop['state']?> <?=$prop['zip_code']?>
                    </span>
                    <strong class="property-price text-primary mb-3 d-block text-success">
                        $<?=$prop['price']?>
                    </strong>
                    <ul class="property-specs-wrap mb-3 mb-lg-0">
                        <li>
                        <span class="property-specs">Beds</span>
                        <span class="property-specs-number">
                            <?=$prop['bedrooms']?> <sup>+</sup>
                        </span>
                        
                        </li>
                        <li>
                        <span class="property-specs">Baths</span>
                        <span class="property-specs-number">
                            <?=$prop['bathrooms']?>
                        </span>
                        
                        </li>
                        <li>
                        <span class="property-specs">SQ FT</span>
                        <span class="property-specs-number">
                            <?=$prop['size_sqft']?>
                        </span>
                        
                        </li>
                    </ul>

                    </div>
                </div>
                </div>

            <?php endforeach;?>

        <?php endif; ?>

    </div>

    </div>
    </div>


    <?php require_once "../includes/footer.php"?>

