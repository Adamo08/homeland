<?php require_once "includes/header.php"?>





<?php



    // Getting row count for all the tables
    $adminsCount = getRowCout('admins');
    $usersCount = getRowCout('users');
    $categoriesCount = getRowCout('categories');
    $propertiesCount = getRowCout('properties');
    $requestsCount = getRowCout('requests');



?>


    <main>
        <div class="container-fluid px-4">

            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <span>Admins</span>
                            <span class="px-2 bg-dark rounded-2">
                                <?=$adminsCount?>
                            </span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo ADMINURL?>admins/admins-list.php">View Admins</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <span>Users</span>
                            <span class="px-2 bg-dark rounded-2">
                                <?=$usersCount?>
                            </span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo ADMINURL?>users/users-list.php">View Users</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <span>Categories</span>
                            <span class="px-2 bg-dark rounded-2">
                                <?=$categoriesCount?>
                            </span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo ADMINURL?>categories/categories-list.php">View Categories</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <span>Properties</span>
                            <span class="px-2 bg-dark rounded-2">
                                <?=$propertiesCount?>
                            </span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo ADMINURL?>properties/properties-list.php">View Properties</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <span>Requests</span>
                            <span class="px-2 bg-dark rounded-2">
                                <?=$requestsCount?>
                            </span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo ADMINURL?>requests/requests-list.php">View Requests</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i>
                            User Registeration
                        </div>
                        <div class="card-body">
                            <canvas id="myLineChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Properties/Catrgory
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch data for the line chart (Users per month)
        fetch('users/get_users_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.month);
                const userData = data.map(item => item.user_count);

                const ctx_1 = document.getElementById('myLineChart').getContext('2d');
                new Chart(ctx_1, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Users',
                            data: userData,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    // Custom callback function to display only integer values
                                    callback: function(value, index, values) {
                                        if (Math.floor(value) === value) {
                                            return value; // Only display integers
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            });

        // Fetch data for the bar chart (Properties by type)
        fetch('categories/get_categories_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.name);  // Extract categories name
                const propertyData = data.map(item => item.property_count);  // Extract property counts

                const ctx_2 = document.getElementById('myBarChart').getContext('2d');
                new Chart(ctx_2, {
                    type: 'bar',
                    data: {
                        labels: labels,  // Use dynamic labels
                        datasets: [{
                            label: 'Properties',
                            data: propertyData,  // Use dynamic data
                            backgroundColor: [
                                '#7FDBFF', '#FF6F61', '#77DD77', '#B19CD9', '#FFDAB9', '#F5FFFA', '#B0E0E6', '#D3D3D3'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    // Custom callback function to display only integer values
                                    callback: function(value, index, values) {
                                        if (Math.floor(value) === value) {
                                            return value; // Only display integers
                                        }
                                    }
                                }                                
                            }
                        }
                    }
                });
            });
    </script>


<?php require_once "includes/footer.php"?>