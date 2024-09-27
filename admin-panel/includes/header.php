<?php require_once "C:/xampp/htdocs/Homeland/admin-panel/helpers/helpers.php"?>
<?php require_once "C:/xampp/htdocs/Homeland/functions/database.php"?>
<?php require_once "C:/xampp/htdocs/Homeland/functions/file_helpers.php"?>


<?php 

    session_start();
    if (!isset($_SESSION['admin_id'])){
        // Go to login
        echo "<script> window.location.href = '".ADMINAUTH."login.php' </script>";
    }else{
        // Getting the admin
        $id = $_SESSION['admin_id'];
        $admin = getAdmin($id);
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
        <title>Dashboard - Homeland Admin</title>
        <link href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css" rel="stylesheet" />
        <link href="<?php echo ADMINURL?>assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?php echo URL('../assets/fonts/icomoon/style.css')?>">
        <link rel="stylesheet" href="<?php echo URL('../assets/css/bootstrap.min.css')?>">

    </head>
    <body class="sb-nav-fixed">
        
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-flex justify-content-between">
            
            <div class="d-flex justify-content-between">
                <!-- Navbar Brand-->
                <a class="navbar-brand ps-3" href="<?php echo ADMINURL?>">
                    <h3 class="font-weight-bold">Homeland</h3>
                </a>
                <!-- Sidebar Toggle-->
                <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            </div>
            
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img   
                            src="<?php echo ADMINASSETS."images/".$admin['image']?>"
                            width="40"
                            height="40"
                            alt="Admin Avatar"
                        >
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <p class="px-3">Welcome back <span class="bg-primary text-white font-weight-bold px-2 rounded-2"><?=$admin['username']?></span></p>
                        <li><a class="dropdown-item" href="<?php echo ADMINURL?>admins/profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="<?php echo ADMINAUTH?>logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>

        </nav>

        <div id="layoutSidenav">

            <div id="layoutSidenav_nav">

                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="<?php echo ADMINURL?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false" aria-controls="collapseAdmins">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                                Admins
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseAdmins" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo ADMINURL?>admins/admins-list.php">List of admins</a>
                                    <a class="nav-link" href="<?php echo ADMINURL?>admins/add-admin.php">Add New Admin</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Users
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo ADMINURL?>users/users-list.php">List of Users</a>
                                    <a class="nav-link" href="<?php echo ADMINURL?>users/add-user.php">Add New User</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                                <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                                Categories
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseCategories" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo ADMINURL?>categories/categories-list.php">List of Categories</a>
                                    <a class="nav-link" href="<?php echo ADMINURL?>categories/add-category.php">Add New Category</a>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProperties" aria-expanded="false" aria-controls="collapseProperties">
                                <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                                Properties
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseProperties" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo ADMINURL?>properties/properties-list.php">List of Properties</a>
                                    <a class="nav-link" href="<?php echo ADMINURL?>properties/add-property.php">Add New Property</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRequests" aria-expanded="false" aria-controls="collapseRequests">
                                <div class="sb-nav-link-icon"><i class="fas fa-envelope-open-text"></i></div>
                                Requests
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseRequests" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo ADMINURL?>requests/requests-list.php">List of Requests</a>
                                </nav>
                            </div>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small mb-2">Logged in as:</div>
                        <span class="bg-primary text-white font-weight-bold px-2 rounded-2">
                            <?=$admin['username']?>
                        </span>
                    </div>
                </nav>

            </div>

            <div id="layoutSidenav_content">