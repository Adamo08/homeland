<?php require_once "../includes/header.php"?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">


<?php 

    if (!isset($_SESSION['admin_id'])){
        echo "<script> window.location.href = '".ADMINAUTH."' </script>";
    }

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        // Getting the gallery
        $galleries = getPropertyGallery($id);
    }
    else{
        echo "<script> window.location.href = '".ADMINURL."404.php' </script>";
    }

?>


<style>
    /* Style the delete icon */
    .delete-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        display: none;
        color: white;
        padding: 5px;
        border-radius: 50%;
        font-size: 1.5rem;
        z-index: 10;
    }

    .card:hover .delete-icon {
        display: block;
    }

    /* Optional: Add a hover effect to the icon */
    .delete-icon:hover {
        color: red;
        cursor: pointer;
    }

</style>

<div class="container pb-5">
    
    <h1 class="my-4 font-weight-bold bg-primary text-white text-center px-3 py-2 rounded-3 h2 h-md1">
        Property Gallery
    </h1>

    <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
        <li class="breadcrumb-item active">Gallery</li>
        <a 
            href="#" 
            class="btn btn-primary"
            data-toggle="modal" 
            data-target="#exampleModal"
        >
            Add Photo
        </a>
    </ol>
    <div class="row g-4">
        <?php if (!empty($galleries)): ?>
            <?php foreach ($galleries as $gallery): ?>
                <!-- Gallery Item -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <a href="http://localhost/Homeland/assets/uploads/properties/galleries/<?=$gallery['image_url']?>" class="image-popup gal-item">
                            <img 
                                src="http://localhost/Homeland/assets/uploads/properties/galleries/<?=$gallery['image_url']?>" 
                                class="img-fluid img-thumbnail h-100" 
                                alt="Property Image"
                            >
                        </a>
                        <a 
                            href="#" 
                            class="delete-icon"
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Delete"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>No galleries found!</strong> Please upload some images for this property.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
</div>

</div>



<!-- Modal to add images -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add photo to galleries</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action=""  id="uploadForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form control mb-3">
                            <input type="hidden" name="property_id" value="<?$id?>">
                            <label for="image">Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <small id="imageError" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>

    // Initializing tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


    $(document).ready(function() {

        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true // Enables the gallery feature
            }
        });

        
    });


</script>




<?php require_once "../includes/footer.php"?>
