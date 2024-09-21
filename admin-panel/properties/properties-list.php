<?php require_once "../includes/header.php"?>



<?php 

    if (!isset($_SESSION['admin_id'])){
        echo "<script> window.location.href = '".ADMINAUTH."' </script>";
    }

    // Getting the list of properties
    $properties = getAllProperties();

    $bgs = [
        'Available' => ['bg-info', 'text-dark'],
        'Pending' => ['bg-success', 'text-light'],
        'Sold' => ['bg-warning', 'text-dark']
    ];


?>

    <style>
        td {
            vertical-align: middle !important;
        }   
    </style>

    <main>
            <div class="container-fluid px-4">

                <h1 class="mt-4">Properties</h1>
                <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
                    <li class="breadcrumb-item active">Properties</li>
                    <a href="add-property.php" class="btn btn-primary">Add New</a>
                </ol>
                <div class="container">
                    <table id="datatablesSimple" class="display">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Property Type</th>
                                <th>Price (USD)</th>
                                <th>Street Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Area</th>
                                <th>Year Built</th>
                                <th>Status</th>
                                <th>Added By</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if(!empty($properties)):?>
                                <?php foreach($properties as $property):?>
                                    <?php 
                                        $bg =  $bgs[$property['status']][0];
                                        $text =  $bgs[$property['status']][0];
                                    ?>
                                    <tr>
                                        <td><?=$property['title']?></td>
                                        <td><?=$property['description']?></td>
                                        <td><?=$property['property_type']?></td>
                                        <td><?=$property['price']?></td>
                                        <td><?=$property['street_address']?></td>
                                        <td><?=$property['city']?></td>
                                        <td><?=$property['state']?></td>
                                        <td><?=$property['area']?></td>
                                        <td><?=$property['year_built']?></td>
                                        <td>
                                            <span class="<?=$bg?> <?=$text?> px-2 rounded-2 font-weight-bold"><?=$property['status']?></span>
                                        </td>
                                        <td><?=getAdminUsername($property['admin_id'])?></td>
                                        <td><?=$property['created_at']?></td>
                                        <td>
                                            <a 
                                                href="#" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Delete"
                                                class="delete-property ml-2"
                                                data-id="<?=$property['id']?>"
                                            >
                                                <i class="icon-trash text-danger"></i>
                                            </a>
                                            <a 
                                                href="#" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Update"
                                                class="edit-property ml-2"
                                                data-id="<?=$property['id']?>"
                                            >
                                                <i class="icon-edit text-info"></i>
                                            </a>
                                            <a 
                                                href="property-gallery.php?id=<?=$property['id']?>" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Gallery"
                                                class="show-gallery ml-2"
                                            >
                                                <i class="icon-image text-info"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                            

                        </tbody>
                    </table>
                </div>
            </div>
    </main>

    <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });

    </script>



    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>


        // Initializing tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Deleting Properties
        $(document).on('click', '.delete-property', function () {

            var id = $(this).data('id');
            var row = $(this).closest('tr');
            if(confirm("Sure u want to delete this property?")){
                $.ajax({
                    url: 'delete_property.php',
                    method: 'POST',
                    data: {
                        property_id: id
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            alert(response.message);
                            console.log('Success:', response.message);

                            // Deleting the corresponding row from the table
                            row.remove();
                        }
                        else
                        {
                            alert('Error: ' + response.message);
                            console.log('Error:', response.message);
                        }

                    },
                    error: function () {
                        console.log('Error:', response.message);
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });

    </script>


<?php require_once "../includes/footer.php"?>
