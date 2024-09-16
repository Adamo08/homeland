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

            // Let's get The List of favorites For the current user
            $favorites = getFavorites($userId);
        }

    
?>


<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../assets/images/img_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
            <h1 class="mb-2">User/favorites</h1>
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
            <h2 class="my-5">List Of Favorites</h2>
            <?php if($isLoggedIn): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Street Address</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($favorites)): ?>

                                <?php foreach ($favorites as $favorite): ?>
                                    <?php 
                                        $status = $favorite['status'];
                                        $className = '';
                                        switch($status){
                                            case 'Available':
                                                $className = 'status-available';
                                                break;
                                            case 'Sold':
                                                $className = 'status-sold';
                                                break;
                                            case 'Pending':
                                                $className = 'status-pending';
                                                break;
                                        }
                                        
                                    ?>
                                    <tr id="row-<?= $favorite['property_id']; ?>">
                                        <td>
                                            <img 
                                                width="60" 
                                                height="60" 
                                                src="https://via.placeholder.com/100" 
                                                alt="Property Image" class="img-fluid">
                                        </td>
                                        <td>
                                            <?=$favorite['property_id']?>
                                        </td>
                                        <td>
                                            <?=$favorite['title']?>
                                        </td>
                                        <td>
                                            <?=$favorite['street_address']?>
                                        </td>
                                        <td>
                                            <span class="<?=$className?>">
                                                <?=$status?>
                                            </span>
                                        </td>
                                        <td>
                                            <?=$favorite['created_at']?>
                                        </td>
                                        <td>
                                            <a 
                                                href="#" 
                                                class="text-danger delete-btn text-decoration-none"
                                                data-id="<?=$favorite['property_id']?>"
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
                                            Your List Of Favorites Is Empty!
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
                    You must be <a href="<?=URL("auth/login.php")?>">Logged In</a> to see the list of your favorites
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            <?php endif;?>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var propertyID = $(this).data('id');
            var userID = '<?=$userId?>';

            // alert(`ProID : ${propertyID} UserID : ${userID}`);

            // Confirm deletion
            if (confirm('Are you sure you want to remove this property from your favorites?')) {
                // Ajax request to remove the favorite
                $.ajax({
                    url: '../favorites/remove_from_favorites.php',
                    method: 'POST',
                    data: {
                        property_id: propertyID,
                        user_id: userID
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#row-' + propertyID).remove();
                            alert('Property removed from favorites');
                            location.reload();
                        } else {
                            alert('Failed to remove property from favorites');
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