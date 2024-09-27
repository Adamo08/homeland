<?php require_once "../includes/header.php"?>

<?php 

    if (!isset($_SESSION['admin_id'])){
        echo "<script> window.location.href = '".ADMINAUTH."' </script>";
        exit();
    }

    // Getting the info of the current admin
    $id = $_SESSION['admin_id'];
    $admin = getAdmin($id);
    $adminAvatarsPath = ADMINASSETS."images/";
    $adminAvatar = $adminAvatarsPath.$admin['image'];

?>

<div class="container">
    <div class="main-body">
    
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb mt-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Admin Profile</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm">

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">

                            <img 
                                src="<?php echo $adminAvatar?>" 
                                alt="Admin Avatar" 
                                class="img rounded-circle" 
                                width="100"
                            >

                            <div class="mt-3">
                                <h4>
                                <?php echo $admin['full_name'] ?? '' ?>
                                </h4>
                                <p class="text-muted font-size-sm">
                                    <?php echo $admin['address'] ?? 'N/A' ?>
                                </p>
                            </div>

                            <div class="mt-3 d-flex gap-2 flex-wrap align-items-center">
                                <p class="bg-info font-weight-bold text-white px-2 py-1 rounded-1">
                                    Joined At
                                </p>
                                <p class="text-muted font-size-sm">
                                    <?php echo date('d M Y', strtotime($admin['created_at'])) ?? 'N/A' ?>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $admin['full_name'] ?? 'N/A' ?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $admin['email'] ?? 'N/A' ?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $admin['phone'] ?? 'N/A' ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $admin['address'] ?? 'N/A' ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-primary w-100 font-weight-bold text-white" target="__blank">Update Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>
    </div>


<?php require_once "../includes/footer.php"?>