<?php require_once "../includes/header.php"?>


<?php

    if (isset($_POST['submit'])){

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $errors = [];

    $full_name = sanitizeInput($_POST['full_name']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
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
    else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Invalid email format.";
        }
    }
    if (empty($password)){
        $errors['password'] = "Password is required.";
    }
    if (empty($phone)){
        $errors['phone'] = "Phone number is required.";
    }
    else{
        if (!preg_match("/^\+\d{1,4}\d{9}$/", $phone)){
            $errors['phone'] = "Invalid phone number format.";
        }
    }
    if (empty($address)){
        $errors['address'] = "Address is required.";
    }

    if (!isset($_FILES['avatar'])){
        $errors['avatar'] = "Avatar is required";
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

                $fileUploadResult = uploadAvatar($_FILES['avatar'], $username, '../../assets/uploads/avatars/');
                if ($fileUploadResult !== false) {
                    $avatarPath = $fileUploadResult; // Store the uploaded avatar's path
                    $avatar = 'avatars/'.$_FILES['avatar']['name'];

                    // Hash the password
                    $hashedPassword = hash('sha256', $password);

                    // Create a new user in the database
                    $newUser = createUser($full_name, $username, $email, $hashedPassword, $phone, $address, $avatar);
                    if ($newUser) {
                        $success = "Usre created successfully";
                    } else {
                        // If user creation fails, remove the uploaded avatar
                        unlink($avatarPath); // Delete the uploaded file
                        $errors['user'] = "Failed to create user.";
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


<main>
    <section>
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-9">

                    <h1 class="my-4 font-weight-bold bg-primary text-white px-3 py-2 rounded-3 text-center">Add New User</h1>

                    <div class="card p-4" style="border-radius: 15px;">

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

                            <?php if (isset($success)):?>
                                <div class="alert alert-success">
                                    <?php echo $success?>
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
                                    class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>"
                                    accept="image/jpeg, image/png, image/webp"    
                                >
                                <div class="small text-danger mt-1">
                                        <?php echo $errors['avatar'] ?? ''?>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input 
                                    type="submit" 
                                    name="submit" 
                                    class="btn btn-primary" 
                                    value="Add user">
                            </div>
                        </form>

                    </div>

                </div>
                </div>
            </div>
    </section>
</main>


<?php require_once "../includes/footer.php"?>
