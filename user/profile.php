<?php require_once "../includes/header.php"?>

<?php 

    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }
    else
    {
        $user = $_SESSION['user'];
        $userId = $user['id'];

        // Getting user details
        $userDetails = getUserDetail($userId);

        $facebookURL = isset($userDetails['facebook']) ? $userDetails['facebook'] : '';
        $instagramURL = isset($userDetails['instagram']) ? $userDetails['instagram'] : '';
        $twitterURL = isset($userDetails['twitter']) ? $userDetails['twitter'] : '';
        $githubURL = isset($userDetails['github']) ? $userDetails['github'] : '';
    }

?>

<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../assets/images/img_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
            <h1 class="mb-2">User/profile</h1>
            </div>
        </div>
    </div>
</div>


<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
                </nav>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div>    
                            <img 
                                src="../assets/uploads/<?=$user['avatar']?>"
                                class="rounded-circle img-fluid"
                                width="100"
                                height="100"
                            >
                            <h5 class="my-3">John Smith</h5>
                            <p class="text-muted mb-1">
                                <?=$userDetails['job']?>
                            </p>
                            <p class="text-muted mb-4">
                                <?=$user['address']?>
                            </p>
                        </div>
                        <div>
                            <ul class="list-group list-group-flush rounded-3">
                                    <?php if(!empty($facebookURL)):?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="icon-facebook text-body"></i> 
                                            <a href="https://www.<?=$facebookURL?>" class="mb-0">
                                                <?=$facebookURL?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                    <?php if(!empty($instagramURL)):?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="icon-instagram" style="color: #55acee;"></i> 
                                            <a href="https://www.<?=$instagramURL?>" class="mb-0">
                                                <?=$instagramURL?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                    <?php if(!empty($twitterURL)):?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="icon-twitter" style="color: #ac2bac;"></i>
                                            <a href="https://www.<?=$twitterURL?>" class="mb-0">
                                                <?=$twitterURL?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                    <?php if(!empty($githubURL)):?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="icon-github" style="color: #3b5998;"></i>
                                            <a href="https://www.<?=$githubURL?>" class="mb-0">
                                                <?=$githubURL?>
                                            </a>
                                        </li>
                                    <?php endif;?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="mb-0 bg-primary text-white font-weight-bold px-2 rounded-1">Full Name</span>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <?=$user['full_name']?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="mb-0 bg-primary text-white font-weight-bold px-2 rounded-1">User Name</span>
                            </div>
                            <div class="col-sm-9">
                                <?=$user['username']?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="mb-0 bg-primary text-white font-weight-bold px-2 rounded-1">Email</span>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <?=$user['email']?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="mb-0 bg-primary text-white font-weight-bold px-2 rounded-1">Phone</span>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <?=$user['phone']?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="mb-0 bg-primary text-white font-weight-bold px-2 rounded-1">Address</span>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <?=$user['address']?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="mb-0 bg-primary text-white font-weight-bold px-2 rounded-1">Joined At</span>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <?php echo date('d M Y', strtotime($user['created_at']))?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body w-100">
                        <a href="settings.php" class="btn btn-primary w-100 font-weight-bold text-white">
                            Edit Your Profile
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>




<?php require_once "../includes/footer.php"?>