<?php require_once "../includes/header.php"?>
<?php require_once "../functions/database.php"?>

<?php 

    if (!isset($_SESSION['user'])){
        echo "<script> window.location.href = '".URL()."'</script>";
        exit();
    }

?>


<?php 
    
        $isLoggedIn = false;
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $isLoggedIn = true;

            // Let's get The List of requests For the current user
            $requests = getUserRequests($userId);
        }

    
?>


<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../assets/images/img_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
            <h1 class="mb-2">User/requests</h1>
            </div>
        </div>
    </div>
</div>


<style>
    table tbody td {
        vertical-align: middle !important;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="my-5">List Of Requests</h2>
            <?php if($isLoggedIn): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Street Address</th>
                                <th>Request Status</th>
                                <th>Date Requested</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($requests)): ?>

                                <?php foreach ($requests as $request): ?>
                                    <?php 
                                        $status = $request['status'];
                                        $className = '';

                                        switch($status){
                                            case 'pending':
                                                $className = 'px-3 rounded-2 font-weight-bold bg-warning text-dark'; // Yellow background for pending
                                                break;
                                            case 'accepted':
                                                $className = 'px-3 rounded-2 font-weight-bold bg-success text-white'; // Green background for accepted
                                                break;
                                            case 'rejected':
                                                $className = 'px-3 rounded-2 font-weight-bold bg-danger text-white'; // Red background for rejected
                                                break;
                                        }
                                        
                                        
                                    ?>
                                    <tr id="row-<?= $request['property_id']; ?>">
                                        <td>
                                            <img 
                                                width="60" 
                                                height="60" 
                                                src="https://via.placeholder.com/100" 
                                                alt="Property Image" class="img-fluid">
                                        </td>
                                        <td>
                                            <?=$request['property_id']?>
                                        </td>
                                        <td>
                                            <?=$request['title']?>
                                        </td>
                                        <td>
                                            <?=$request['street_address']?>
                                        </td>
                                        <td>
                                            <span class="<?=$className?>">
                                                <?=$status?>
                                            </span>
                                        </td>
                                        <td>
                                            <?=$request['created_at']?>
                                        </td>
                                        <td>
                                            <a 
                                                href="#" 
                                                class="text-danger delete-btn text-decoration-none"
                                                data-id="<?=$request['id']?>"
                                            >
                                                <i class="icon-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else:?>
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-info alert-dismissible fade show">
                                            Your List Of Requests Is Empty!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif;?>

                        </tbody>
                    </table>
                </div>
            <?php else:?>
                <div class="alert alert-info alert-dismissible fade show mt-2">
                    You must be <a href="<?=URL("auth/login.php")?>">Logged In</a> to see the list of your requests
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            <?php endif;?>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $(".delete-btn").on('click', function(){
            // alert("Delete ben clicked");
            var id = $(this).data('id');
            var row = $(this).closest('tr');

            if (confirm("Are you sure you want to remove this request?")){
                $.ajax({
                    method: 'POST',
                    url: '../requests/remove_from_requests.php',
                    data: {
                        request_id: id
                    },


                    success: function(response) {
                        if (response.status === 'success') {
                            row.remove();
                            alert('Property removed from requests');
                        } else {
                            alert('Failed to remove property from requests');
                        }
                    },


                    error: function(response) {
                        console.log('Error:', response);
                        alert('An error occurred. Please try again.');
                    }


                });
            }
        });
    });
</script>



<?php require_once "../includes/footer.php"?>