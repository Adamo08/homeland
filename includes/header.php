  <?php 

    if (session_status() === PHP_SESSION_NONE){
      session_start();
    }

  ?>

  <?php  require_once "C:/xampp/htdocs/HomeLand/functions/helpers.php"?>
  <?php  require_once "C:/xampp/htdocs/HomeLand/functions/file_helpers.php"?>
  <?php  require_once "C:/xampp/htdocs/HomeLand/functions/database.php"?>

  <?php 
    $user = @$_SESSION['user'];
    
    // Tha avatar of the user
    $avatar = @$user['avatar'];

  ?>



    <?php 
    
      // Getting all the categories
      $categories = getAllcategories(true);
    
    ?>


  <!DOCTYPE html>
  <html lang="en">
    <head>
      <title>Homeland &mdash; Colorlib Website Template</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
      <link rel="stylesheet" href="<?php echo URL('assets/fonts/icomoon/style.css')?>">

      <link rel="stylesheet" href="<?php echo URL('assets/css/bootstrap.min.css')?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/magnific-popup.css')?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/jquery-ui.css')?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/owl.carousel.min.css')?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/owl.theme.default.min.css')?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/bootstrap-datepicker.css') ?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/mediaelementplayer.css') ?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/animate.css') ?>">
      <link rel="stylesheet" href="<?php echo URL('assets/fonts/flaticon/font/flaticon.css') ?>">
      <link rel="stylesheet" href="<?php echo URL('assets/css/fl-bigmug-line.css') ?>">
      
    
      <link rel="stylesheet" href="<?php echo URL('assets/css/aos.css') ?>">

      <link rel="stylesheet" href="<?php echo URL('assets/css/style.css') ?>">
      
      <!-- Bootstrap Link  -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      
    </head>
    <body>
    
    <div class="site-loader"></div>
    
    <div class="site-wrap">

      <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div> <!-- .site-mobile-menu -->

      <div class="site-navbar mt-4">
          <div class="container py-1">
            <div class="row align-items-center">
              <div class="col-8 col-md-8 col-lg-4">
                <h1 class="mb-0"><a href="<?php echo URL('')?>" class="text-white h2 mb-0"><strong>Homeland<span class="text-danger">.</span></strong></a></h1>
              </div>
              <div class="col-4 col-md-4 col-lg-8">
                <nav class="site-navigation text-right text-md-right" role="navigation">

                  <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

                  <ul class="site-menu js-clone-nav d-none d-lg-block mr-5">
                    <li class="active">
                      <a href="<?php echo URL('')?>">Home</a>
                    </li>
                    <li><a href="<?php echo URL('buy.php')?>">Buy</a></li>
                    <li><a href="<?php echo URL('rent.php')?>">Rent</a></li>
                    <li class="has-children">
                      <a href="#">Properties</a>
                      <ul class="dropdown arrow-top">
                        <?php foreach($categories as $category): ?>
                          <li>
                            <a href="<?php echo URL("categories/category.php?type=".htmlspecialchars($category['name']))?>">
                              <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                          </li>
                        <?php endforeach;?>
                      </ul>
                    </li>
                    <li><a href="<?php echo URL('about.php')?>">About</a></li>
                    <li><a href="<?php echo URL('contact.php')?>">Contact</a></li>
                    <?php if(!isset($_SESSION['user'])):?>
                      <li><a href="<?php echo URL('auth/login.php')?>">Login</a></li>
                      <li><a href="<?php echo URL('auth/register.php')?>">Register</a></li>
                    <?php else:?>
                      <!-- Display user avatar and dropdown if logged in -->
                      <li class="has-children">
                        <img src="<?php echo URL('assets/uploads/' . $avatar); ?>" alt="Avatar" class="avatar-img">
                        <ul class="dropdown arrow-top">
                          <li class="pl-3 py-3">
                            Welcome 
                            <span class="username-span">
                              <?=$_SESSION['user']['username']?>
                            </span>
                          </li>
                          <li><a href="<?php echo URL('user/profile.php')?>">Profile</a></li>
                          <li><a href="<?php echo URL('user/settings.php')?>">Settings</a></li>
                          <li><a href="<?php echo URL('user/favorites.php')?>">Favorites</a></li>
                          <li><a href="<?php echo URL('user/requests.php')?>">Requests</a></li>
                          <li class="username-span"><a href="<?php echo URL('auth/logout.php')?>">Logout</a></li>
                        </ul>
                      </li>
                    <?php endif;?>
                  </ul>
                </nav>
              </div>
            

            </div>
          </div>
        </div>
      </div>