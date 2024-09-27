<?php require_once "../includes/header.php"?>
<?php require_once "../helpers/helpers.php"?>


<?php 

    if (isset($_POST['submit'])){
        // echo "<pre>";
        //     print_r($_POST);
        // echo "</pre>";

        $errors = [];
        $full_name = sanitizeInput($_POST['full_name']);
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $address = sanitizeInput($_POST['address']);
        $phone = sanitizeInput($_POST['phone']);
        $password = sanitizeInput($_POST['password']);

        // Validation
        if (empty($full_name)) {
            $errors['full_name'] = "Full name is required";
        }
        if (empty($username)) {
            $errors['username'] = "Username is required";
        }
        if (empty($address)) {
            $errors['address'] = "Address is required";
        }
        if (empty($email)) {
            $errors['email'] = "Email is required";
        }
        else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format";
            }
        }
        if (empty($phone)) {
            $errors['phone'] = "Phone number is required";
        }
        else{
            if (!preg_match("/^\+\d{1,4}\d{9}$/", $phone)) {
                $errors['phone'] = "Invalid phone number";
            }
        }
        if (empty($password)) {
            $errors['password'] = "Password is required";
        }

        if (!isset($_FILES['avatar'])){
            $errors['avatar'] = "Avatar is required";
        }


        // If there was no error
        if (empty($errors)) {
            // Check Existance
            $check_admin = getAdminByEmailAndUsername($username, $email);
            if ($check_admin){
                $errors['admin'] = "An admin with the same email or username already exists";
            }
            else
            {
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $fileUploadResult = uploadAvatar($_FILES['avatar'],$username,'../assets/images/admins/');
                    if ($fileUploadResult !== false) {
                        $avatarPath = $fileUploadResult; // Store the uploaded avatar's path
                        $avatar = 'admins/'.$_FILES['avatar']['name'];

                        // echo $avatarPath;
    
                        // Hash the password
                        $hashedPassword = hash('sha256', $password);
    
                        // Create a new user in the database
                        $newAdmin = createAdmin($full_name, $username, $email, $phone,$address, $hashedPassword, $avatar);
                        if ($newAdmin) {
                            $success = "Admin created successfully";
                        } else {
                            // If admin creation fails, remove the uploaded avatar
                            unlink($avatarPath); // Delete the uploaded file
                            $errors['admin'] = "Failed to create admin.";
                        }
                    }
                    else{
                        $errors['avatar'] = $_SESSION['upload_error'];
                    }
                }
                else {
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

                <h1 class="my-4 font-weight-bold bg-primary text-white px-3 py-2 rounded-3 text-center">Add New Admin</h1>

                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">

                        <form action="" method="POST" enctype="multipart/form-data">

                            <?php if (isset($errors['admin'])):?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['admin']?>
                                </div>
                            <?php endif?>

                            <?php if (isset($success)):?>
                            <div class="alert alert-success">
                                <?php echo $success?>
                            </div>
                            <?php endif?>

                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="full_name" class="mb-0 font-weight-bold">Full name</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        type="text" 
                                        id="full_name" 
                                        name="full_name" 
                                        class="form-control form-control-lg <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" 
                                        placeholder="Full name"
                                        value= "<?=@$_POST['full_name']?>"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['full_name'] ?? ''?>
                                    </div>

                                </div>
                            </div>
    
                            <hr class="mx-n3">
    
                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="username" class="mb-0 font-weight-bold">User Name</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        type="text" 
                                        id="username" 
                                        name="username" 
                                        class="form-control form-control-lg <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                        placeholder="Admin username"
                                        value= "<?=@$_POST['username']?>"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['username'] ?? ''?>
                                    </div>
    
                                </div>
                            </div>
    
                            <hr class="mx-n3">
    
                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="email" class="mb-0 font-weight-bold">Email address</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        type="text" 
                                        id="email" 
                                        name="email" 
                                        class="form-control form-control-lg <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                        placeholder="example@example.com" 
                                        value= "<?=@$_POST['email']?>"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['email'] ?? ''?>
                                    </div>
    
                                </div>
                            </div>
    
                            <hr class="mx-n3">
    
                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="phone" class="mb-0 font-weight-bold">Phone Number</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        class="form-control form-control-lg <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                                        placeholder="Phone number" 
                                        value= "<?=@$_POST['phone']?>"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['phone'] ?? ''?>
                                    </div>
    
                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="address" class="mb-0 font-weight-bold">Admin Address</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        type="tel" 
                                        id="address" 
                                        name="address" 
                                        class="form-control form-control-lg <?= isset($errors['address']) ? 'is-invalid' : '' ?>" 
                                        placeholder="address" 
                                        value= "<?=@$_POST['address']?>"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['address'] ?? ''?>
                                    </div>
    
                                </div>
                            </div>
    
                            <hr class="mx-n3">
    
                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="password" class="mb-0 font-weight-bold">Password</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        type="password" 
                                        class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                        id="password" 
                                        name="password" 
                                        placeholder="Admin password"
                                        value= "<?=@$_POST['password']?>"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['password'] ?? ''?>
                                    </div>
    
                                </div>
                            </div>
    
                            <hr class="mx-n3">
    
                            <div class="row align-items-center">
                                <div class="col-md-3 ps-5">
    
                                    <label for="avatar" class="mb-0 font-weight-bold">Upload Avatar</label>
    
                                </div>
                                <div class="col-md-9 pe-5">
    
                                    <input 
                                        class="form-control form-control-lg <?= isset($errors['avatar']) ? 'is-invalid' : '' ?>" 
                                        name="avatar" id="avatar" 
                                        type="file" 
                                        accept="image/jpeg, image/png, image/webp"
                                    />
                                    <div class="small text-danger mt-1">
                                        <?php echo $errors['avatar'] ?? ''?>
                                    </div>
    
                                </div>
                            </div>
    
                            <hr class="mx-n3">
    
                            <div class="px-5 py-4">
                                <button 
                                    type="submit"
                                    name="submit" 
                                    class="btn btn-primary btn-lg"
                                >Add Admin</button>
                            </div>
                        </form>


                    </div>
                </div>

            </div>
            </div>
        </div>
    </section>
</main>


<?php require_once "../includes/footer.php"?>
