    <?php 
      // If a user is already loged in
      session_start();
      if (isset($_SESSION['user'])){
          header('Location: http://localhost/Homeland/');
      }
    ?>

    <?php require_once "../includes/header.php"?>
    <?php  require_once "../functions/database.php"?>
    

    <?php 
    
        if (isset($_POST['submit'])){
          
            $errors = [];

            $email = sanitizeInput($_POST['email']);
            $password = sanitizeInput($_POST['password']);

            if (empty($email)){
              $errors['email'] = "Email is required";
            }
            if (empty($password)){
              $errors['password'] = "Password is required";
            }

            // If there was no errors
            if (empty($errors)){
              $hashedPassword = hash('sha256',$password);
              // Getting the user from db
              $user = getUserByEmailAndPassword($email,$hashedPassword);
              if ($user){
                // If the user exists
                $_SESSION['user'] = $user;
                // Redirect the user to the index.php page
                echo "<script> window.location.href = 'http://localhost/Homeland/' </script>";
                exit();
              }
              else{
                // If the user doesn't exists
                $errors['email'] = "Email or password is incorrect";
              }
            }

        }
    
    ?>
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../assets/images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-10">
            <h1 class="mb-2">Auth/Log In</h1>
          </div>
        </div>
      </div>
    </div>
    

    <div class="site-section">
      <div class="container">
        <div class="row align-items-center">

          <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="h4 text-black widget-title mb-3">Login</h3>
            <form action="" method="POST" class="form-contact-agent">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>


                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="text" 
                        id="email"
                        name="email"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="form-control">
                </div>
                <div class="form-group">
                    <input 
                        type="submit" 
                        id="submit"
                        name="submit"
                        class="btn btn-primary" 
                        value="Login"
                    >
                </div>
            </form>
          </div>

          <!-- New column for illustration -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <img 
                  src="<?php echo URL('assets/images/login-illustration.jpg')?>" 
                  alt="Illustration" 
                  class="img-fluid w-100 h-100"
                >
          </div>

        </div>
      </div>
    </div>




  <?php require_once "../includes/footer.php"?>