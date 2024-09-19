<?php require_once "../includes/header.php"?>


<?php 

    if(isset($_POST['submit'])){

        $errors = [];

        $name = sanitizeInput($_POST['name']);
        $description = sanitizeInput($_POST['description']);

        // Validation
        if (empty($name)){
            $errors['name'] = "Name is required";
        }
        if (empty($description)){
            $errors['description'] = "Description is required";
        }

        if (empty($errors)) {
            // Insert data into database
            $insertResult = insertCategory($name,$description);
            if ($insertResult) {
                $success = "Category created successfully";
            }
            else{
                $error = "Failed to create category";
            }
        }

    }


?>

<main>
    
    <section class="container mt-3">

        <h1 class="my-4 font-weight-bold bg-primary text-white px-3 py-2 rounded-3 text-center">Add New Category</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
                    <li class="breadcrumb-item active">Categories</li>
                    <a href="categories-list.php" class="btn btn-primary">View List</a>
                </ol>
        <div class="card p-4">
            <form action="" method="POST">

                <?php if(isset($success)):?>   
                    <div class="alert alert-success my-2">
                        <?php echo $success ?? ''?>
                    </div>
                <?php endif;?>
                <?php if(isset($error)):?>     
                    <div class="alert alert-danger my-2">
                        <?php echo $error ?? ''?>
                    </div>
                <?php endif;?>

                <!-- Category Name Input Group -->
                <div class="mb-3 form-group">
                    <div class="input-group has-validation">
                        <span class="input-group-text">Category Name: </span>
                        <input 
                            type="text" 
                            class="form-control <?php if(isset($errors['name'])) echo 'is-invalid'?>" 
                            id="categoryName"
                            name="name"
                            placeholder="Enter category name" 
                            value="<?=@$_POST['name']?>"
                        >
                        <div class="invalid-feedback">
                            <?php echo $errors['name'] ?? ''?>
                        </div>
                    </div>
                </div>

                <!-- Category Description Input Group -->
                <div class="mb-3 form-group">
                    <div class="input-group has-validation">
                        <span class="input-group-text">Category Description: </span>
                        <input 
                            class="form-control <?php if(isset($errors['description'])) echo 'is-invalid'?>" 
                            id="categoryDescription"
                            name="description" 
                            placeholder="Enter category description" 
                            value="<?=@$_POST['description']?>"
                        ></input>
                        <div class="invalid-feedback">
                            <?php echo $errors['description'] ?? ''?>                        
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="btn btn-primary" type="submit" name="submit">Add Category</button>
            </form>
        </div>
        
    </section>

</main>


<?php require_once "../includes/footer.php"?>
