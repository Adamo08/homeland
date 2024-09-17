<?php require_once "../includes/header.php"?>


<?php 

    if (!isset($_SESSION['admin_id'])){
        echo "<script> window.location.href = '".ADMINAUTH."' </script>";
    }

    // Getting the list of categories
    $categories = getAllCategories();


?>


    <main>
            <div class="container-fluid px-4">

                <h1 class="mt-4">Categories</h1>
                <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
                    <li class="breadcrumb-item active">Categories</li>
                    <a href="add-category.php" class="btn btn-primary">Add New</a>
                </ol>
                <div class="container">
                    <table id="datatablesSimple" class="display">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Property Count</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if(!empty($categories)):?>
                                <?php foreach($categories as $category):?>
                                    <tr>
                                        <td><?=$category['name']?></td>
                                        <td><?=$category['description']?></td>
                                        <td><?=$category['property_count']?></td>
                                        <td><?=$category['created_at']?></td>
                                        <td>
                                            <a 
                                                href="#" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Delete"
                                                class="delete-category ml-2"
                                                data-id="<?=$category['id']?>"
                                            >
                                                <i class="icon-trash text-danger"></i>
                                            </a>
                                            <a 
                                                href="#" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Update"
                                                class="edit-category ml-2"
                                                data-id="<?=$category['id']?>"
                                                data-category="<?=$category['name']?>"
                                                data-description="<?=$category['description']?>"
                                            >
                                                <i class="icon-edit text-info"></i>
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                <button type="button" class="close" id="hide-modal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="formUpdateCategory">
                    <div class="form-group">
                        <input type="hidden" name="category_id" id="categoryID">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input 
                            type="text" id="name" 
                            name="category_name"  
                            class="form-control" 
                            placeholder="Category Name.."
                        >
                        <div class="small text-danger" id="cat-name-err"></div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input 
                            type="text" id="description" 
                            name="category_description"  
                            class="form-control" 
                            placeholder="Category Description.."
                        >
                        <div class="small text-danger" id="cat-desc-err"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update-button">Update</button>
            </div>
            </div>
        </div>
    </div>

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

        $(document).ready(function(){

            // Hide Modal 
            $("#hide-modal").on('click',function(){
                $("#exampleModal").modal('hide');
            });

            // Show Modal
            $(document).on('click','.edit-category',function () {

                var $id = $(this).data('id');
                var $category = $(this).data('category');
                var $description = $(this).data('description');

                // alert (`${$id}, ${$category}, ${$description}`);

                // Setting values to form inputs
                
                $("#categoryID").val($id);
                $("#name").val($category);
                $("#description").val($description);


                // Show the modal
                $('#exampleModal').modal('show');
            });


            // Validate inputs
            $("#name").on('input', function() {
                $(this).removeClass('is-invalid');
                if ($("#cat-name-err").length) {
                    $("#cat-name-err").text('');
                }
            });

            $("#description").on('input', function() {
                $(this).removeClass('is-invalid');
                if ($("#cat-desc-err").length) {
                    $("#cat-desc-err").text('');
                }
            });

            // Update Category
            $("#update-button").on('click',function(){
                // Getting form fields
                var id = $("#categoryID").val();
                var name = $("#name").val().trim();
                var description = $("#description").val().trim();
                
                if (name === "") {
                    $("#name").addClass('is-invalid');
                    $("#cat-name-err").text("Category Name Is Required!");
                    return;
                }
                if (description === "") {
                    $("#description").addClass('is-invalid');
                    $("#cat-desc-err").text("Category Description Is Required!");
                    return;
                }

                $.ajax({
                    url: 'update_category.php',
                    method: 'POST',
                    data: {
                        category_id: id,
                        category_name: name,
                        category_description: description
                    },

                    success: function (response){
                        
                        if(response.status === 'success'){
                            alert(response.message);
                            console.log('Success:', response.message);
                            // Hiding the modal
                            $("#exampleModal").modal('hide');
                        }
                        else{
                            console.log('Error:', response.message);
                        }
                    },

                    error: function (response){
                        console.log('Error:', response.message);
                        alert('An error occurred. Please try again.');
                    }
                    
                });
                

            });

            // Delete Category
            $(document).on('click','.delete-category',function () {
                // alert(`Deleting category with id: `+ $(this).data('id'));
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                if (confirm("Are you sure you want to delete this category? All the related properties will be deleted also!")){
                    $.ajax({
                        url: 'delete_category.php',
                        method: 'POST',
                        data: {
                            category_id: id
                        },

                        // Success
                        success: function(response){
                            if(response.status === 'success'){

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

                        // Error
                        error: function(response){
                            console.log('Error:', response.message);
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });
    
    
        });



    </script>



<?php require_once "../includes/footer.php"?>
