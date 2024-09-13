    <?php require_once "includes/header.php"?>
    <?php require_once "functions/database.php"?>

    <?php 

      // Getting some properties to display in the slide
      $some_properties = getAllProperties(4);
      // var_dump($some_properties);
    
      // Getting all the properties
      $properties = getAllProperties();
      // var_dump($properties);

      $bgs = [
        'For Rent' => ['bg-info', 'text-dark'],            // Light Blue with Dark Text
        'For Sale' => ['bg-success', 'text-light'],        // Green with Light Text
        'For Lease' => ['bg-warning', 'text-dark'],        // Yellow with Dark Text
        'For Rent or Sale' => ['bg-primary', 'text-light'],// Blue with Light Text
        'For Sale or Lease' => ['bg-secondary', 'text-light'], // Gray with Light Text
        'For Rent or Lease' => ['bg-light', 'text-dark'],  // Light Gray with Dark Text
        'For Rent, Sale, or Lease' => ['bg-dark', 'text-light'] // Dark Gray with Light Text
      ];

      // Getting the disponible cities
      $cities = getAllCities();
    
    ?>

    <?php 
    
      // Handling the search form
      if (isset($_POST['search'])) {

          unset($_GET['view']);

          // Get the selected values from the form
          $listingType = $_POST['list-types'];
          $offerType = $_POST['offer-types'];
          $city = $_POST['select-city'];

          // Debugging
          // var_dump($listingType, $offerType, $city);

          // Call a function to get properties based on these search parameters
          $properties = searchProperties($listingType, $offerType, $city);
      
        }
    
    ?>

    <?php 

        if (isset($_GET['view'])){


          $view = $_GET['view'] ?? 'all';
          switch ($view) {
              case 'rent':
                  $offerType = 'For Rent';
                  break;
              case 'sale':
                  $offerType = 'For Sale';
                  break;
              default:
                  $offerType = ''; // No specific filter
                  break;
          }
          
          $properties = searchPropertiesByofferType($offerType);
        

        }


    ?>
    <?php 


        // Handle Sort form submission
        if (isset($_POST['sortBy'])) {
            $sortOrder = $_POST['sort'] ?? 'asc'; // Default to ascending if not set


            // Sort properties based on selected order
            if ($sortOrder) {
                $properties = sortProperties($properties, $sortOrder);
            }
        }
    ?>





    <div class="slide-one-item home-slider owl-carousel">

      <?php foreach($some_properties as $prop): ?>
        <?php 
            $status = $prop['property_status'];
            $bg = $bgs[$status][0];
            $text = $bgs[$status][1];
          
        ?>    
        <div class="site-blocks-cover overlay" style="background-image: url(assets/uploads/properties/images/<?=$prop['image']?>);" data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-10">
                      <span class="d-inline-block <?=$bg?> <?=$text?> px-3 mb-3 property-offer-type rounded">
                        <?=$status?>
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
                          class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2 text-decoration-none"
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
            <form class="form-search col-md-12" method="POST" action="" style="margin-top: -100px;">
              <div class="row align-items-end">
                  <div class="col-md-3">
                      <label for="list-types">Listing Types</label>
                      <div class="select-wrap">
                          <span class="icon icon-arrow_drop_down"></span>
                          <select name="list-types" id="list-types" class="form-control d-block rounded-0">
                              <option value="">All</option>
                              <?php foreach($categories as $category):?>
                                <option 
                                    value="<?php echo htmlspecialchars($category['name']);?>" 
                                    <?php if (@$_POST['list-types'] === $category['name']) echo 'selected'?>
                                >
                                  <?php echo $category['name'];?>
                                </option>
                              <?php endforeach?>
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
                <a href="index.php" class="icon-view view-module active text-decoration-none"><span class="icon-view_module"></span></a>
                <a href="view-list.php" class="icon-view view-list text-decoration-none"><span class="icon-view_list"></span></a>
              </div>

              <div class="ml-auto d-flex align-items-center">
                <div>
                  <a href="index.php?view=all" class="view-list px-3 border-right active">All</a>
                  <a href="index.php?view=rent" class="view-list px-3 border-right">Rent</a>
                  <a href="index.php?view=sale" class="view-list px-3">Sale</a>
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
                  $bg = $bgs[$status][0];
                  $text = $bgs[$status][1];
                ?>

                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="property-entry h-100">
                    <a 
                      href="<?php echo URL("property-details.php?id=$prop[id]")?>" 
                      class="property-thumbnail text-decoration-none"
                    >
                      <div class="offer-type-wrap">
                        <span class="offer-type <?=$bg?> <?=$text?>">
                          <?=$prop['property_status']?>
                        </span>
                      </div>
                      <img src="assets/uploads/properties/images/<?=$prop['image']?>" alt="Image" class="img-fluid">
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

    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center">
            <div class="site-section-title">
              <h2>Recent Blog</h2>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate officia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
            <a href="#"><img src="assets/images/img_4.jpg" alt="Image" class="img-fluid text-decoration-none"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#" class="text-decoration-none">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
            <a href="#"><img src="assets/images/img_2.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#" class="text-decoration-none">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="300">
            <a href="#"><img src="assets/images/img_3.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#" class="text-decoration-none">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>

        </div>

      </div>
    </div>

    
    <div class="site-section bg-light">
    <div class="container">
      <div class="row mb-5 justify-content-center">
        <div class="col-md-7">
          <div class="site-section-title text-center">
            <h2>Our Agents</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero magnam officiis ipsa eum pariatur labore fugit amet eaque iure vitae, repellendus laborum in modi reiciendis quis! Optio minima quibusdam, laboriosam.</p>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
            <div class="team-member">

              <img src="assets/images/person_1.jpg" alt="Image" class="img-fluid rounded mb-4">

              <div class="text">

                <h2 class="mb-2 font-weight-light text-black h4">Megan Smith</h2>
                <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi dolorem totam non quis facere blanditiis praesentium est. Totam atque corporis nisi, veniam non. Tempore cupiditate, vitae minus obcaecati provident beatae!</p>
                <p>
                  <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                </p>
              </div>

            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
            <div class="team-member">

              <img src="assets/images/person_2.jpg" alt="Image" class="img-fluid rounded mb-4">

              <div class="text">

                <h2 class="mb-2 font-weight-light text-black h4">Brooke Cagle</h2>
                <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, cumque vitae voluptates culpa earum similique corrupti itaque veniam doloribus amet perspiciatis recusandae sequi nihil tenetur ad, modi quos id magni!</p>
                <p>
                  <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                </p>
              </div>

            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
            <div class="team-member">

              <img src="assets/images/person_3.jpg" alt="Image" class="img-fluid rounded mb-4">

              <div class="text">

                <h2 class="mb-2 font-weight-light text-black h4">Philip Martin</h2>
                <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores illo iusto, inventore, iure dolorum officiis modi repellat nobis, praesentium perspiciatis, explicabo. Atque cupiditate, voluptates pariatur odit officia libero veniam quo.</p>
                <p>
                  <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                </p>
              </div>

            </div>
          </div>

          

        </div>
    </div>
    </div>
    

    <?php require_once "includes/footer.php"?>