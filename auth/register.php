
    <?php 
        // If a user is already loged in
        session_start();
        if (isset($_SESSION['user'])){
            header('Location: http://localhost/Homeland/');
        }
    ?>

    <?php require_once "../includes/header.php"?>
    <?php require_once "../config/config.php"?>
    <?php  require_once "../functions/file_helpers.php"?>
    <?php  require_once "../functions/database.php"?>

    <?php 
    
    
        // Register Logic
        if (isset($_POST['submit'])){

            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";

            $errors = [];

            $full_name = sanitizeInput($_POST['full_name']);
            $username = sanitizeInput($_POST['username']);
            $email = sanitizeInput($_POST['email']);
            $password = sanitizeInput($_POST['password']);
            $repassword = sanitizeInput($_POST['repassword']);
            $phone = sanitizeInput($_POST['phone']);
            $address = sanitizeInput($_POST['address']);

            if (empty($full_name)){
                $errors['full_name'] = "Full name is required.";
            }
            if (empty($username)){
                $errors['username'] = "Username is required.";
            }
            if (empty($email)){
                $errors['email'] = "Email is required.";
            }
            if (empty($password)){
                $errors['password'] = "Password is required.";
            }
            if (empty($repassword)){
                $errors['repassword'] = "Confirm password is required.";
            }
            if ($password != $repassword){
                $errors['match_pass'] = "Passwords do not match.";
            }
            if (empty($phone)){
                $errors['phone'] = "Phone number is required.";
            }
            if (empty($address)){
                $errors['address'] = "Address is required.";
            }

            // Email and phone format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['format_email'] = "Invalid email format.";
            }
            if (!preg_match('/^\+\d{1,4}\d{9}$/', $phone)){
                $errors['format_phone'] = "Invalid phone number format.";
            }



            // If there was no errors
            if (empty($errors)) {
                // Check if user already exists
                $user = getUser($username, $email);
                if ($user) {
                    $errors['user_exists'] = "User already exists.";
                } else {

                    // Process file upload first
                    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

                        $fileUploadResult = uploadAvatar($_FILES['avatar'], $username, '../assets/uploads/avatars/');
                        if ($fileUploadResult !== false) {
                            $avatarPath = $fileUploadResult; // Store the uploaded avatar's path
                            $avatar = 'avatars/'.$_FILES['avatar']['name'];
        
                            // Hash the password
                            $hashedPassword = hash('sha256', $password);
        
                            // Create a new user in the database
                            $newUser = createUser($full_name, $username, $email, $hashedPassword, $phone, $address, $avatar);
                            if ($newUser) {
                                // If user creation is successful, redirect to login page
                                header('Location: login.php');
                                exit(); // Ensure no further code is executed
                            } else {
                                // If user creation fails, remove the uploaded avatar
                                unlink($avatarPath); // Delete the uploaded file
                                $errors['create_user'] = "Failed to create user.";
                            }
                        } else {
                            $errors['avatar'] = $_SESSION['upload_error'];
                        }

                    } else {
                        $errors['avatar'] = "Avatar upload failed.";
                    }
                }
            }

        

        }
    
    
    ?>

    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../assets/images/img_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10">
                    <h1 class="mb-2">Auth/Register</h1>
                </div>
            </div>
        </div>
    </div>


    <div class="site-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Existing registration form column -->
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="h4 text-black widget-title mb-3">Register</h3>
                    <form action="" method="POST" class="form-contact-agent" enctype="multipart/form-data">


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
                            <label for="full_name">Full Name</label>
                            <input 
                                type="text" 
                                id="full_name" 
                                name="full_name"
                                class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" 
                                placeholder="Full Name"
                                value="<?=@$_POST['full_name']?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                placeholder="Username"
                                value="<?=@$_POST['username']?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input 
                                type="text" 
                                id="email" 
                                name="email" 
                                class="form-control <?= isset($errors['email']) || isset($errors['format_email']) ? 'is-invalid' : '' ?>"
                                placeholder="Email Address" 
                                value="<?=@$_POST['email']?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                placeholder="Password"
                                value="<?=@$_POST['password']?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="repassword">Confirm Password</label>
                            <input 
                                type="password" 
                                id="repassword" 
                                name="repassword" 
                                class="form-control <?= isset($errors['repassword']) ? 'is-invalid' : '' ?>"
                                placeholder="Confirm Password"
                                value="<?=@$_POST['repassword']?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                class="form-control <?= isset($errors['phone']) || isset($errors['format_phone']) ? 'is-invalid' : '' ?>"
                                placeholder="Phone Number"
                                value="<?=@$_POST['phone']?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                                placeholder="Address"
                                value="<?=@$_POST['address']?>"
                                >
                        </div>
                        <div class="form-outline">
                            <label for="avatar">Upload Avatar</label>
                            <input 
                                type="file" 
                                id="avatar" 
                                name="avatar" 
                                class="form-control pb-5"
                                accept="image/jpeg, image/png, image/webp"    
                            >
                            <small class="form-text text-muted">
                                Please upload an image named as your username (e.g., john_doe.jpg). Accepted formats: JPEG, PNG, WebP.
                            </small>
                        </div>
                        <div class="form-group mt-3">
                            <input 
                                type="checkbox" 
                                id="terms"
                                checked
                                required
                            >
                            <label for="terms">I agree to the <a href="#">terms and conditions</a></label>
                        </div>
                        <div class="form-group">
                            <input 
                                type="submit" 
                                name="submit" 
                                class="btn btn-primary" 
                                value="Register">
                        </div>
                    </form>
                </div>

                <!-- New column for illustration -->
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <img 
                        src="<?php echo URL('assets/images/register-illustration.jpg')?>" 
                        alt="Illustration" 
                        class="img-fluid w-100 h-100"

                    >
                </div>
            </div>
        </div>
    </div>


    <?php require_once "../includes/footer.php"?>
