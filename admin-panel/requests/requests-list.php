<?php require_once "../includes/header.php"?>


<?php 

    // Let's get The List of all requests 
    $requests = getAllRequests();


?>


<main>
<style>
    table tbody td {
        vertical-align: middle !important;
        text-align: center;
    }
    /* Available */
    .status-available {
    background-color: #28a745; /* Green */
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    }

    /* Sold */
    .status-sold {
    background-color: #dc3545; /* Red */
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    }

    /* Pending */
    .status-pending {
    background-color: #ffc107; /* Yellow */
    color: black;
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="my-5">List Of Requests</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Street Address</th>
                                <th>Property Status</th>
                                <th>Date Requested</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($requests)): ?>

                                <?php foreach ($requests as $request): ?>
                                    <?php 
                                        $status = $request['status'];
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
                                            <!-- Remove request  -->
                                            <a 
                                                href="#"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Remove" 
                                                class="text-danger delete-btn text-decoration-none"
                                            >
                                                <i class="icon-close"></i>
                                            </a>
                                            <!-- Update Request Status  -->
                                            <a 
                                                href="#"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Update" 
                                                class="text-primary edit-btn text-decoration-none ml-2"
                                            >
                                                <i class="icon-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else:?>
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-info alert-dismissible fade show">
                                            No requests yet!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif;?>

                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>


</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
     // Initializing tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

<?php require_once "../includes/footer.php"?>
