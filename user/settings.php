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

        $socialLinks = [
            'facebook' => $facebookURL,
            'instagram' => $instagramURL,
            'twitter' => $twitterURL,
            'github' => $githubURL
        ];
    }

?>

<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../assets/images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
            <h1 class="mb-2">User/Edit Profile</h1>
            </div>
        </div>
    </div>
</div>



<div class="container rounded bg-white mt-3">
    <div class="row">

        <div class="col-md-4 border-right">

            <div class="d-flex flex-column align-items-center text-center py-5">
                <img class="rounded-circle mt-5"  src="../assets/uploads/<?=$user['avatar']?>" width="90">
                <span class="font-weight-bold">
                    <?=$user['full_name']?>
                </span>
                <span class="text-black-50">
                    <?=$user['email']?>
                </span>
                <span class="bg-primary text-white rounded-1 px-1 mt-2">
                    <?=$userDetails['job']?>
                </span>
            </div>

            <div class="table-responsive">
                <h6>Social Links</h6>
                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th>Platform</th>
                            <th>Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach($socialLinks as $social => $link): ?>
                        <?php if(!empty($link)): ?>
                            <tr id="row-<?=$social?>">
                                <td><i class="icon-<?=$social?>"></i></td>
                                <td><a href="https://www.<?=$link?>" target="_blank">link</a></td>
                                <td>
                                    <a 
                                        href="#" 
                                        class="text-primary mr-2 edit-social" 
                                        data-social="<?=$social?>" 
                                        data-link="<?=$link?>" 
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="Update"
                                    >
                                        <i class="icon-edit"></i>
                                    </a>
                                    <a 
                                        href="#" 
                                        class="text-danger delete-social" 
                                        data-social="<?=$social?>" 
                                        data-link="<?=$link?>"
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="Delete"
                                    >
                                        <i class="icon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>

                        
                    </tbody>
                </table>
            </div>

            
        </div>

        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-row align-items-center back">
                        <a href="<?=URL()?>" class="text-decoration-none"><i class="icon-arrow-left mr-1 mb-1"></i></a>
                        <h6>Back to home</h6>
                    </div>
                    <h6 class="text-right">Edit Profile</h6>
                </div>
                <form action="update_profile.php" method="POST" id="update-profile">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <input type="hidden" name="user_id" value="<?=$userId?>">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="full_name" class="font-weight-bold">Full name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="full_name"
                                name="full_name"
                                placeholder="Full name" 
                                value="<?=$user['full_name']?>">
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="font-weight-bold">Username</label>
                            <input 
                                type="text" 
                                class="form-control"
                                id="username"
                                name="username"
                                placeholder="Username"
                                value="<?=$user['username']?>"> 
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="email"
                                name="email"
                                placeholder="Email"
                                value="<?=$user['email']?>">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="font-weight-bold">Phone number</label>
                            <input 
                                type="text" 
                                class="form-control"
                                id="phone"
                                name="phone"
                                placeholder="Phone number"
                                value="<?=$user['phone']?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="address" class="font-weight-bold">Address</label>
                            <input 
                                type="text" 
                                class="form-control"
                                id="address"
                                name="address" 
                                placeholder="Address" 
                                value="<?=$user['address']?>">
                        </div>
                        <div class="col-md-6">
                            <label for="job" class="font-weight-bold">Job Title</label>
                            <input 
                                type="text" 
                                class="form-control"
                                id="job"
                                name="job" 
                                placeholder="Job Title" 
                                value="<?=$userDetails['job']?>">
                        </div>
                    </div>
                    <div class="mt-5">
                        <button 
                            type="button"
                            class="btn btn-primary profile-button"
                            id="profile-button"
                        >
                            Save Profile
                        </button>
                
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Link</h5>
            <button type="button" class="close" id="hide-modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" class="w-100 p-2">
                <div class="form-group">
                    <div class="input-group">
                        <!-- Static part of the URL (prefix) -->
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="social-prefix"></span>
                        </div>
                        <!-- User-entered part of the URL -->
                        <input 
                            type="text" 
                            class="form-control" 
                            id="social-input" 
                            placeholder="Enter your username"
                        >
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="update-button">Update</button>
        </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>

    // Initializing tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $(document).ready(function(){

        // Update profile
        $("#profile-button").on('click',function (){
            var $form = $("#update-profile");
            var $formData = $form.serialize();

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $formData,

                success: function(response){
                    if (response.status == 'success'){
                        alert(response.message);
                        console.log(response);
                        
                        location.reload();
                    }
                    else{
                        var $emptyFields = response.empty_fields;
                            for (var field in $emptyFields) {
                                var $input = $form.find(`[name=${field}]`);
                                
                                // Add Bootstrap 'is-invalid' class to highlight the field
                                $input.addClass('is-invalid');
                                
                                // Insert a span with class 'invalid-feedback' for error message
                                // $input.after(`<div class="invalid-feedback">${field.replace('_', ' ')} is required</div>`);
                            }
                    }
                },
                error: function(response){
                    console.log('Error:', response);
                    alert('An error occurred. Please try again.');
                }
            });
            
        });

        // Show Modal
        $(document).on('click', '.edit-social', function() {
            var social = $(this).data('social');
        
            $('#social-prefix').text(social + '/');
            
            // Show the modal
            $('#exampleModal').modal('show');
        });

        // Hide Modal
        $("#hide-modal").on('click',function(){
            $("#exampleModal").modal('hide');
        });

        // Handle Update Button Click
        $("#update-button").on('click', function() {
            var social = $("#social-prefix").text().replace('/', '');
            var username = $("#social-input").val().trim();
            var userId = <?=$userId?>;
            var fullUrl = social + '.com/' + username;

            // Validate inputs
            if (username === "") {
                // alert("Username cannot be empty.");
                $("#social-input").addClass('is-invalid');
                return;
            }

            $.ajax({
                type: "POST",
                url: "update_social_link.php",
                data: {
                    user_id: userId,
                    social: social,
                    new_url: fullUrl
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Social link updated successfully!');
                        $('#exampleModal').modal('hide'); // Hide the modal after update
                        location.reload();
                    } else {
                        alert('Failed to update the social link: ' + response.message);
                    }
                },
                error: function(response) {
                    console.log('Error:', response);
                    alert('An error occurred. Please try again.');
                }
            });
        });


        // Handle Delete Button Click
        $(document).on('click','.delete-social', function() {
            var social = $(this).data('social');
            var userId = <?=$userId?>;

            if (
                confirm("Are u sure you want to remove this link?")
            )
            {
                
                $.ajax({
                    url: 'remove_social_link.php',
                    method: 'POST',
                    data : {
                        social : social,
                        user_id : userId
                    },


                    success: function (response){
                        if (response.status == 'success'){
                            $("#row-"+social).remove();
                            alert(`${social} link removed successfully`);
                        }
                        else{
                            alert('Failed to update the social link: ' + response.message);
                        }
                    },

                    error: function (response){
                        console.log('Error:', response);
                        alert('An error occurred. Please try again.');
                    }


                });
            }

        });

    });


</script>





<?php require_once "../includes/footer.php"?>