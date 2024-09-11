    <?php require_once "includes/header.php"?>
    <?php require_once "functions/database.php"?>


    <?php 

      // Getting properties that are For Sale
      $propsForSell = searchPropertiesByofferType('For Sale');

      // Slicing the array to show some props in the slider
      $propsForSellSlice = array_slice($propsForSell, 0, 4);

      // var_dump($propsForSell);
      //var_dump($propsForSellSlice);

      // Getting the disponible cities
      $cities = getAllCities();
    
    ?>



    <?php 
    
      // Handling the searching form
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){
        
        // Get the selected values from the form
        $listingType = $_POST['list-types'];
        $offerType = 'For Sale';
        $city = $_POST['select-city'];

        // Debugging
        // var_dump($listingType, $offerType, $city);

        // Call a function to get properties based on these search parameters
        $propsForSell = searchProperties($listingType, $offerType, $city);
    
      }
    
    ?>


    <?php 
    
       // Handle Sort form submission
      if (isset($_POST['sortBy'])) {
        $sortOrder = $_POST['sort'] ?? 'asc'; // Default to ascending if not set


        // Sort properties based on selected order
        if ($sortOrder) {
            $propsForSell = sortProperties($propsForSell, $sortOrder);
        }
      }

    ?>

    <div class="slide-one-item home-slider owl-carousel">

      <?php foreach($propsForSellSlice as $prop): ?>
          <div class="site-blocks-cover overlay" style="background-image: url(assets/uploads/properties/images/<?=$prop['image']?>);" data-aos="fade" data-stellar-background-ratio="0.5">
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
                  <option value="">All</option>
                      <option value="Condo" <?php if (@$_POST['list-types'] === 'Condo') echo 'selected'?>>Condo</option>
                      <option value="Commercial Building" <?php if (@$_POST['list-types'] === 'Commercial Building') echo 'selected'?>>Commercial Building</option>
                      <option value="House" <?php if (@$_POST['list-types'] === 'House') echo 'selected'?>>House</option>
                      <option value="Property Land" <?php if (@$_POST['list-types'] === 'Property Land') echo 'selected'?>>Property Land</option>
                      <option value="Office" <?php if (@$_POST['list-types'] === 'Office') echo 'selected'?>>Office</option>
                      <option value="Apartment" <?php if (@$_POST['list-types'] === 'Apartment') echo 'selected'?>>Apartment</option>
                      <option value="Retail" <?php if (@$_POST['list-types'] === 'Retail') echo 'selected'?>>Retail</option>
                      <option value="Warehouse">Warehouse</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <label for="offer-types">Offer Type</label>
                <div class="select-wrap">
                  <span class="icon icon-arrow_drop_down"></span>
                  <select name="offer-types" id="offer-types" class="form-control d-block rounded-0">
                    <option value="For Sale" selected>For Sale</option>
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

            <?php if (empty($propsForSell)): ?>

                <div class="col-12">
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                    No properties found matching your criteria.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                </div>

            <?php else: ?>

                <?php foreach($propsForSell as $prop): ?>
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
                        <img src="assets/uploads/properties/images/<?=$prop['image']?>" alt="Image" class="img-fluid">
                      </a>
                      <div class="p-4 property-body">
                        <a href="#" class="property-favorite text-decoration-none"><span class="icon-heart-o"></span></a>
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

    <div class="site-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 text-center">
            <div class="site-section-title">
              <h2>Why Choose Us?</h2>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate officia.</p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-4">
            <a href="#" class="service text-center text-decoration-none">
              <span class="icon flaticon-house"></span>
              <h2 class="service-heading">Research Subburbs</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iure qui natus perspiciatis ex odio molestia.</p>
              <p><span class="read-more">Read More</span></p>
            </a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="#" class="service text-center text-decoration-none">
              <span class="icon flaticon-sold"></span>
              <h2 class="service-heading">Sold Houses</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iure qui natus perspiciatis ex odio molestia.</p>
              <p><span class="read-more">Read More</span></p>
            </a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="#" class="service text-center text-decoration-none">
              <span class="icon flaticon-camera"></span>
              <h2 class="service-heading">Security Priority</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iure qui natus perspiciatis ex odio molestia.</p>
              <p><span class="read-more">Read More</span></p>
            </a>
          </div>
        </div>
      </div>
    </div>

    
    <?php require_once "includes/footer.php"?>