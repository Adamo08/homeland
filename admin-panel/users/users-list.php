<?php require_once "../includes/header.php"?>



<?php 

    if (!isset($_SESSION['admin_id'])){
        echo "<script> window.location.href = '".ADMINAUTH."' </script>";
    }

    // Getting the list of users
    $users = getUsers();
    $i = 0;

?>

    <main>
        <div class="container-fluid px-4">

            <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item active">Users</li>
                <a href="add-user.php" class="btn btn-primary">Add New</a>
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
                            <th>Address</th>
                            <th>Joined AT</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($users)):?>
                            <?php foreach($users as $user):?>
                                <tr>
                                    <td><?=++$i?></td>
                                    <td><?=$user['full_name']?></td>
                                    <td><?=$user['username']?></td>
                                    <td><?=$user['email']?></td>
                                    <td><?=$user['phone']?></td>
                                    <td><?=$user['address']?></td>
                                    <td><?=$user['created_at']?></td>
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
