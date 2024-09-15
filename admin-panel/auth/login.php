<?php require_once "../helpers/helpers.php"?>
<?php require_once "../../functions/database.php"?>



<?php 

    session_start();
    if (isset($_SESSION['admin_id'])){
        // Go to login
        echo "<script> window.location.href = '".ADMINURL."' </script>";
    }


?>


<?php 

if (isset($_POST['submit'])){
    
    $errors = [];

    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    if (empty($email)){
        $errors['email'] = "Email is required";
    }
    else{
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Invalid email format";
        }
    }
    if (empty($password)){
        $errors['password'] = "Password is required";
    }

    // If there was no errors
    if (empty($errors)){
        $hashedPassword = hash('sha256',$password);
        // Getting the user from db
        $admin = getAdminByEmailAndPassword($email,$hashedPassword);
        if ($admin){
            // If the admin exists
            $_SESSION['admin_id'] = $admin['id'];
            // Redirect the admin to the index.php page
            echo "<script> window.location.href = '".ADMINURL."' </script>";
            exit();
            // echo "Admin Found";
            // var_dump($admin);
        }
        else{
            // If the admin doesn't exists
            $errors['email'] = "Email or password is incorrect";
        }
    }

    $email_err = isset($errors['email']) ? $errors['email'] : null;
    $pass_err = isset($errors['password']) ? $errors['password'] : null;

}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Homeland Admin</title>
        <link href="<?php echo ADMINURL?>assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <style>
        body{
            background: #EEE;
        }
    </style>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Hello <span class="bg-primary text-white px-2 font-weight-bold rounded-2">Admin!</span></h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="POST">
                                            <div class="form-floating">
                                                <input 
                                                    class="form-control <?php if($email_err) echo "is-invalid"?>" 
                                                    id="inputEmail" 
                                                    type="text" 
                                                    name="email"
                                                    value="<?=@$_POST['email']?>"
                                                    placeholder="name@example.com" 
                                                />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <?php if (@$email_err):?>
                                                <div class="small mt-1 text-danger">
                                                    <?=@$email_err?>
                                                </div>
                                            <?php endif;?>
                                            <div class="form-floating mt-3">
                                                <input 
                                                    class="form-control <?php if($pass_err) echo "is-invalid"?>" 
                                                    id="inputPassword" 
                                                    type="password" 
                                                    name="password"
                                                    value="<?=@$_POST['password']?>"
                                                    placeholder="Password" 
                                                />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <?php if (@$pass_err):?>
                                                <div class="small mt-1 text-danger">
                                                    <?=@$pass_err?>
                                                </div>
                                            <?php endif;?>
                                            <div class="form-check mt-3">
                                                <input 
                                                    class="form-check-input" 
                                                    id="inputRememberPassword" 
                                                    type="checkbox" 
                                                    value="" 
                                                />
                                                <label 
                                                    class="form-check-label" 
                                                    for="inputRememberPassword"
                                                >Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="forget_password.php">Forgot Password?</a>
                                                <button type="submit" name="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
