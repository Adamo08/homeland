<?php require_once "includes/header.php"?>
<?php require_once "functions/database.php"?>

    <?php 
    
      $isLoggedIn = false;
      if (isset($_SESSION['user'])) {
        $userId = $_SESSION['user']['id'];
        $full_name = $_SESSION['user']['full_name'];
        $email = $_SESSION['user']['email'];
        $phone = $_SESSION['user']['phone'];
        $isLoggedIn = true;
      }
    
    ?>

    <?php 

      if (isset($_GET['id'])){

        
        $propertyID = $_GET['id'];
        
        // Getting the property by ID
        $property = getPropertyByID($propertyID);

        // echo "<pre>";
        // print_r($property);
        // echo "</pre>";

        $propertyType = $property['property_type'];
        $state = $property['state'];

        // Getting the gallery
        $galleries = getPropertyGallery($propertyID);

        // Slice the galleries
        $galleriesSliced = array_slice($galleries, 0, 3);

        // echo "<pre>";
        // print_r($galleries);
        // echo "</pre>";


        // Getting the related properties to the current prop
        $relatedProperties = getRelatedProperties(
                                                $propertyType,
                                                        $state,
                                            $propertyID
                                                );

        // echo "<pre>";
        // print_r($relatedProperties);
        // echo "</pre>";


        $bgs = [
          'For Rent' => ['bg-info', 'text-dark'],            // Light Blue with Dark Text
          'For Sale' => ['bg-success', 'text-light'],        // Green with Light Text
          'For Lease' => ['bg-warning', 'text-dark'],        // Yellow with Dark Text
          'For Rent or Sale' => ['bg-primary', 'text-light'],// Blue with Light Text
          'For Sale or Lease' => ['bg-secondary', 'text-light'], // Gray with Light Text
          'For Rent or Lease' => ['bg-light', 'text-dark'],  // Light Gray with Dark Text
          'For Rent, Sale, or Lease' => ['bg-dark', 'text-light'] // Dark Gray with Light Text
        ];


        // For Requests
        // Check for success or error query parameters
        $success = isset($_GET['success']) ? $_GET['success'] : null;
        $error = isset($_GET['error']) ? $_GET['error'] : null;

        $message = '';

        if ($success == '1') {
            $message = 'Request successfully submitted!';
        } elseif ($success == '0') {
            $message = 'Failed to submit the request.';
            
            if ($error == 'invalid_email') {
                $message = 'Invalid email address. Please provide a valid email.';
            }
        }

      }
      else{
        // Redirect To 404 page
        echo "<script> window.location.href = '".URL('404.php')."'</script>";
        exit();
      }
    
    ?>

    <?php 
    
      // For sharing buttons
      $street_address = $property['street_address'];
      $city = $property['city'];
      $price = $property['price'];

      // Get the current page URL (even on localhost)
      $page_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

      // Compose a share message (for Twitter, for example)
      $share_message = "Check out this property at $street_address, $city for $$price!";
      $encoded_message = urlencode($share_message);
      $encoded_url = urlencode($page_url);
    
    
    ?>

    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(assets/uploads/properties/images/<?=$property['image']?>);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-10">
            <span class="d-inline-block text-white px-3 mb-3 property-offer-type rounded">Property Details of</span>
            <h1 class="mb-2">
              <?=$property['street_address']?>
            </h1>
            <p class="mb-5"><strong class="h2 text-success font-weight-bold">
              $<?=$property['price']?>
            </strong></p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section site-section-sm">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div>
              <div class="slide-one-item home-slider owl-carousel">
                <?php foreach($galleriesSliced as $gallery): ?>
                  <div><img src="<?php echo URL("assets/uploads/properties/galleries/" . htmlspecialchars($gallery['image_url'])); ?>" alt="Image" class="img-fluid"></div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="bg-white property-body border-bottom border-left border-right">
              <div class="row mb-5">
                <div class="col-md-6">
                  <strong class="text-success h1 mb-3">
                    $<?=$property['price']?>
                  </strong>
                </div>
                <div class="col-md-6">
                  <ul class="property-specs-wrap mb-3 mb-lg-0  float-lg-right">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">
                      <?=$property['bedrooms']?> <sup>+</sup>
                    </span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">
                      <?=$property['bathrooms']?>
                    </span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">
                      <?=$property['size_sqft']?> m<sup>2</sup>
                    </span>
                    
                  </li>
                </ul>
                </div>
              </div>
              <div class="row mb-5">
                <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                  <span class="d-inline-block text-black mb-0 caption-text">Home Type</span>
                  <strong class="d-block">
                    <?=$propertyType?>
                  </strong>
                </div>
                <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                  <span class="d-inline-block text-black mb-0 caption-text">Year Built</span>
                  <strong class="d-block">
                    <?=$property['year_built']?>
                  </strong>
                </div>
                <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                  <span class="d-inline-block text-black mb-0 caption-text">Price/Sqft</span>
                  <strong class="d-block">
                    $<?=$property['price_sqft']?>
                  </strong>
                </div>
              </div>

              <h2 class="h4 text-black">More Info</h2>
              <ul>
                <li>
                  <?=$property['description']?>
                </li>
                <li>
                  <?=$property['features']?>
                </li>
              </ul>
              
              <div class="row no-gutters mt-5">

                <div class="col-12">
                  <h2 class="h4 text-black mb-3">Gallery</h2>
                </div>
                <?php foreach($galleries as $gallery): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <a href="<?php echo URL("assets/uploads/properties/galleries/" . htmlspecialchars($gallery['image_url'])); ?>" class="image-popup gal-item">
                            <img src="<?php echo URL("assets/uploads/properties/galleries/" . htmlspecialchars($gallery['image_url'])); ?>" alt="Image" class="img-fluid img-thumbnail h-100">
                        </a>
                    </div>
                <?php endforeach; ?>

              </div>
            </div>
          </div>

          <div class="col-lg-4">

            <div class="bg-white widget border rounded">

                <h3 class="h4 text-black widget-title mb-3">Contact Agent</h3>
                <?php if($isLoggedIn):?>
                  <form action="<?php echo URL('requests/add_request.php') ?>" method="POST" class="form-contact-agent">
                  
                      <div class="form-group">
                        <input 
                            type="hidden" 
                            name="property_id" 
                            value="<?php echo $propertyID; ?>">
                        <input 
                            type="hidden" 
                            name="user_id" 
                            value="<?php echo $userId; ?>">
                      </div>

                      <div class="form-group">
                        <label for="name">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control" 
                            value="<?php echo $full_name?>"
                            required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control"
                            value="<?php echo $email?>"
                            required>
                      </div>
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            class="form-control" 
                            value="<?php echo $phone?>"
                            required>
                      </div>
                      <div class="form-group">
                          <?php if(!inRequests($userId,$propertyID)):?>
                              <input 
                                  type="submit" 
                                  name="submit" 
                                  class="btn btn-primary"
                                  value="Send Request">
                          <?php else:?>
                            <input 
                                  type="submit" 
                                  name="submit" 
                                  class="btn btn-primary"
                                  value="Request Already Sent"
                                  disabled
                            >
                          <?php endif; ?>
                      </div>

                      <div class="notification mt-3 text-success">
                          <?php if (!empty($message)): ?>
                              <p><?php echo htmlspecialchars($message); ?></p>
                          <?php endif; ?>
                      </div>

                  </form>
                <?php else:?>
                  <div class="alert alert-info">
                    <ul>
                      <li>
                        Sorry, you are not allowed to send a message to this property owner.
                      </li>
                      <li>
                        You must be <a href="<?=URL("auth/login.php")?>">Logged in</a> To send a request
                      </li>
                    </ul>
                  </div>
                <?php endif;?>

            </div>

            <div class="bg-white widget border rounded">
              <h3 class="h4 text-black widget-title mb-3 ml-0">Share</h3>
              <div class="px-3" style="margin-left: -15px;">
                  <!-- Facebook share (just sharing the URL, Facebook will fetch metadata like title and image) -->
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>" class="pt-3 pb-3 pr-3 pl-0" target="_blank">
                      <span class="icon-facebook"></span>
                  </a>
                  <!-- Twitter share with custom message -->
                  <a href="https://twitter.com/intent/tweet?text=<?php echo $encoded_message; ?>&url=<?php echo $encoded_url; ?>" class="pt-3 pb-3 pr-3 pl-0" target="_blank">
                      <span class="icon-twitter"></span>
                  </a>
                  <!-- LinkedIn share (just sharing the URL) -->
                  <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $encoded_url; ?>" class="pt-3 pb-3 pr-3 pl-0" target="_blank">
                      <span class="icon-linkedin"></span>
                  </a>    
              </div>            
            </div>


            <div class="bg-white widget border rounded">
                <h3 class="h4 text-black widget-title mb-3 ml-0">Add to favorites</h3>
                <div class="px-3 d-flex align-items-center" style="margin-left: -15px;">
                  <?php if($isLoggedIn): ?>
                    <form id="favorite-form" method="POST" action="favorites/add_to_favorites.php">
                        <input type="hidden" name="property_id" value="<?php echo $propertyID; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                        <?php if (!inFavorites($userId,$propertyID)):?>
                          <div class="d-flex align-items-center">
                            <button type="button" class="icon-heart-o text-danger border-0 bg-transparent mt-10 fs-3" id="add-to-favorites"></button>
                            <p class="mb-0" id="favorite-status">Click the icon to add this property to your favorites.</p>
                          </div>
                        <?php else:?>
                          <div class="d-flex align-items-center">
                            <button type="button" class="icon-heart text-danger border-0 bg-transparent mt-10 fs-3"></button>
                            <p class="mb-0" id="favorite-status">Property added to favorites</p>
                          </div>
                        <?php endif?>
                    </form>
                  <?php else:?>
                    <p class="mb-0 alert alert-info" id="favorite-status">You must be <a href="<?=URL('auth/login.php')?>">logged in</a> to add this to favorites </p>
                  <?php endif?>
                </div>            
            </div>



          </div>
          
        </div>
      </div>
    </div>

    <div class="site-section site-section-sm bg-light">
      <div class="container">

        <div class="row">
          <div class="col-12">
            <div class="site-section-title mb-5">
              <h2>Related Properties</h2>
            </div>
          </div>
        </div>
      
        <div class="row mb-5">

          <?php if(!empty($relatedProperties)): ?>
              <?php foreach($relatedProperties as $relatedProperty):?>
                <?php 
                      $status = $relatedProperty['property_status'];
                      $bg = $bgs[$status][0];
                      $text = $bgs[$status][1];
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                      <div class="property-entry h-100">
                        <a 
                          href="<?php echo URL("property-details.php?id=$relatedProperty[id]")?>" 
                          class="property-thumbnail text-decoration-none"
                        >
                          <div class="offer-type-wrap">
                            <span class="offer-type <?=$bg?> <?=$text?>">
                              <?=$relatedProperty['property_status']?>
                            </span>
                          </div>
                          <img src="assets/uploads/properties/images/<?=$relatedProperty['image']?>" alt="Image" class="img-fluid">
                        </a>
                        <div class="p-4 property-body">
                          <a href="#" class="property-favorite text-decoration-none"><span class="icon-heart-o"></span></a>
                          <h2 class="property-title">
                            <a href="<?php echo URL("property-details.php?id=$relatedProperty[id]")?>"
                            >
                              <?=$relatedProperty['street_address']?>
                            </a>
                          </h2>
                          <span class="property-location d-block mb-3">
                            <span class="property-icon icon-room"></span> 
                            <?=$relatedProperty['street_address']?>
                            <?=$relatedProperty['unit']?>
                            <?=$relatedProperty['city']?>, 
                            <?=$relatedProperty['state']?> <?=$relatedProperty['zip_code']?>
                          </span>
                          <strong class="property-price text-primary mb-3 d-block text-success">
                            $<?=$relatedProperty['price']?>
                          </strong>
                          <ul class="property-specs-wrap mb-3 mb-lg-0">
                            <li>
                              <span class="property-specs">Beds</span>
                              <span class="property-specs-number">
                                <?=$relatedProperty['bedrooms']?> <sup>+</sup>
                              </span>
                              
                            </li>
                            <li>
                              <span class="property-specs">Baths</span>
                              <span class="property-specs-number">
                                <?=$relatedProperty['bathrooms']?>
                              </span>
                              
                            </li>
                            <li>
                              <span class="property-specs">SQ FT</span>
                              <span class="property-specs-number">
                                <?=$relatedProperty['size_sqft']?>
                              </span>
                              
                            </li>
                          </ul>

                        </div>
                      </div>
                    </div>
              <?php endforeach;?>
          <?php else:?>
            <div class="col-12 alert alert-info alert-dismissible fade show" role="alert">
              No related properties found.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif;?>

        </div>
      </div>


    

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
          $(document).ready(function() {
              $('#add-to-favorites').on('click', function() {
                  var $form = $('#favorite-form');
                  // console.table($form.serialize());
                  $.ajax({
                      url: $form.attr('action'),
                      method: 'POST',
                      data: $form.serialize(),
                      success: function(response) {
                        if (response.status === 'success') {
                            $('#favorite-status').text(response.message);
                            $('#add-to-favorites')
                              .addClass('icon-heart text-danger') // Add filled heart icon class
                              .removeClass('icon-heart-o') // Remove outlined heart icon class
                              .off('click'); // Disable the click event on the icon
                        } else {
                            $('#favorite-status').text(response.message);
                        }
                      },
                      error: function() {
                          // Handle error
                          $('#favorite-status').text('An error occurred. Please try again.');
                      }
                  });
              });
          });
      </script>
    
    <?php require_once "includes/footer.php"?>