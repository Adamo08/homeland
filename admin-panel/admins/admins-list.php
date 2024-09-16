<?php require_once "../includes/header.php"?>



<?php 

    if (!isset($_SESSION['admin_id'])){
        echo "<script> window.location.href = '".ADMINAUTH."' </script>";
        exit();
    }

    // Getting the list of admins
    $admins = getAdmins();
    $id = $_SESSION['admin_id'];
    $i = 0;

?>

    <main>
        <div class="container-fluid px-4">

            <h1 class="mt-4">Admins</h1>
            <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item active">Admins</li>
                <a href="add-admin.php" class="btn btn-primary">Add New</a>
            </ol>
            <div class="container">
                <table id="datatablesSimple" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Joined AT</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($admins)):?>
                            <?php foreach($admins as $admin):?>
                                <?php 
                                    $disabled = $admin['id'] === $id ? 'disabled' : '';
                                ?>
                                <tr>
                                    <td><?=++$i?></td>
                                    <td><?=$admin['full_name']?></td>
                                    <td><?=$admin['username']?></td>
                                    <td><?=$admin['email']?></td>
                                    <td><?=$admin['phone']?></td>
                                    <td><?=$admin['created_at']?></td>
                                    <td>
                                        <a href="#" class="btn btn-primary <?=$disabled?>">
                                            <i class="fas fa-comment-dots"></i>
                                            Contact
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


<?php require_once "../includes/footer.php"?>
