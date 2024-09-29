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


<style>
    .card {
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col, .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }
    .mb-3, .my-3 {
        margin-bottom: 1rem!important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }
    .h-100 {
        height: 100%!important;
    }
    .shadow-none {
        box-shadow: none!important;
    }

</style>

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
                                <a 
                                    class="btn btn-primary w-100 font-weight-bold text-white" 
                                    target="__blank"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#exampleModal"
                                >
                                    Update Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>

    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card mb-3">
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row has-validation">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    class="form-control"
                                    type="text"
                                    id="full_name"
                                    value="<?php echo $admin['full_name'] ?? 'N/A' ?>"
                                >
                                <div class="invalid-feedback">Full name cannot be empty</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row has-validation">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    value="<?php echo $admin['email'] ?? 'N/A' ?>"
                                >
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row has-validation">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    class="form-control"
                                    type="text"
                                    id="phone"
                                    value="<?php echo $admin['phone'] ?? 'N/A' ?>"
                                >
                                <div class="invalid-feedback">Please enter a valid 10-digit phone number</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row has-validation">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    class="form-control"
                                    type="text"
                                    id="address"
                                    value="<?php echo $admin['address'] ?? 'N/A' ?>"
                                >
                                <div class="invalid-feedback">Address cannot be empty</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary Update-info">Update Info</button>
        </div>
        
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('.Update-info').click(function(){

            var adminId = <?php echo $id?>;
            var admin = {
                full_name: "<?php echo $admin['full_name']?>",
                email: "<?php echo $admin['email']?>",
                phone: "<?php echo $admin['phone']?>",
                address: "<?php echo $admin['address']?>"
            };

            var fieldsToUpdate = {};

            var full_name = $("#full_name").val().trim();
            var email = $("#email").val().trim();
            var phone = $('#phone').val().trim();
            var address = $('#address').val().trim();

            // Email and phone number regex patterns
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var phonePattern = /^[0-9]{10}$/;

            var isValid = true;

            // Full Name Validation
            if (full_name === "") {
                $("#full_name").addClass("is-invalid");
                isValid = false;
            } else {
                $("#full_name").removeClass("is-invalid");
            }

            // Email Validation
            if (email === "" || !emailPattern.test(email)) {
                $("#email").addClass("is-invalid");
                isValid = false;
            } else {
                $("#email").removeClass("is-invalid");
            }

            // Phone Validation
            if (phone === "" || !phonePattern.test(phone)) {
                $("#phone").addClass("is-invalid");
                isValid = false;
            } else {
                $("#phone").removeClass("is-invalid");
            }

            // Address Validation
            if (address === "") {
                $("#address").addClass("is-invalid");
                isValid = false;
            } else {
                $("#address").removeClass("is-invalid");
            }

            // If validation fails, stop the process
            if (!isValid) {
                return;
            }

            // Check for differences and update fieldsToUpdate
            if (full_name !== admin.full_name) {
                fieldsToUpdate.full_name = full_name;
            }
            if (email !== admin.email) {
                fieldsToUpdate.email = email;
            }
            if (phone !== admin.phone) {
                fieldsToUpdate.phone = phone;
            }
            if (address !== admin.address) {
                fieldsToUpdate.address = address;
            }

            // Check if there are any changes
            if (Object.keys(fieldsToUpdate).length > 0) {
                fieldsToUpdate.admin_id = adminId;

                $.ajax({
                    url: 'update_profile.php',
                    method: 'POST',
                    data: fieldsToUpdate,
                    success: function(response) {
                        if(response.status === 'success'){
                            alert(response.message);
                            console.log('Success:', response.message);
                            // Hiding the modal
                            $("#exampleModal").modal('hide');
                            // Reloading document
                            location.reload(); 
                        }
                        else{
                            console.log('Error:', response.message);
                        }
                    },
                    error: function(response) {
                        console.log('Error:', response.message);
                        alert('An error occurred. Please try again.');
                    }
                });
            } else {
                alert('No changes detected');
            }

        });
    });

</script>

<?php require_once "../includes/footer.php"?>