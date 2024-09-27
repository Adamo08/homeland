<?php require_once "../includes/header.php"; ?>

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

    .request-pending {
        background-color: #007bff; /* Blue */
    }
    .request-accepted {
        background-color: #28a745; /* Green */
    }
    .request-rejected {
        background-color: #dc3545; /* Red */
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
                            <th>User</th>
                            <th>Name</th>
                            <th>Street Address</th>
                            <th>Property Status</th>
                            <th>Request Status</th>
                            <th>Date Requested</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requests)): ?>
                            <?php foreach ($requests as $request): ?>
                                <?php 
                                    $status = $request['status'];
                                    $request_status = $request['request_status'];

                                    $className = '';
                                    $statusClass = '';

                                    switch($status) {
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

                                    switch($request_status) {
                                        case 'accepted':
                                            $statusClass = 'request-accepted';
                                            break;
                                        case 'pending':
                                            $statusClass = 'request-pending';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'request-rejected';
                                            break;
                                    }
                                ?>
                                <tr id="row-<?= $request['property_id']; ?>">
                                    <td>
                                        <img width="60" height="60" src="https://via.placeholder.com/100" alt="Property Image" class="img-fluid">
                                    </td>
                                    <td><?= $request['user_id'] ?></td>
                                    <td><?= $request['title'] ?></td>
                                    <td><?= $request['street_address'] ?></td>
                                    <td>
                                        <span class="<?= $className ?>"><?= $status ?></span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-white px-3 py-1 rounded-2 <?= $statusClass ?>" id="request_status_<?= $request['id'] ?>">
                                            <?= $request['request_status'] ?>
                                        </span>
                                    </td>
                                    <td><?= $request['created_at'] ?></td>
                                    <td>
                                        <a 
                                            href="#" 
                                            data-request-status="<?= $request['request_status'] ?>"
                                            data-request-id="<?= $request['id'] ?>"
                                            data-property-status="<?= $request['status'] ?>"
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
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-info alert-dismissible fade show">
                                        No requests yet!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal to update request status -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update request status</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        </div>
                        <select class="custom-select" id="requestStatus">
                            <option value="pending">Pending</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-save">Update</button>
            </div>
        </div>
    </div>
</div>

</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Initializing tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Show modal
        $(document).on('click', '.edit-btn', function() {
            $("#exampleModal").modal('show');

            var requestId = $(this).data("request-id");
            var requestStatus = $(this).data("request-status");
            var tdStatus = $("#request_status_" + requestId); // Select the correct status span based on requestId

            // Select the option with the requestStatus value
            $("#requestStatus").val(requestStatus);
            $("#requestStatus option[value='" + requestStatus + "']").prop('disabled', true);

            // When the btn-save is clicked 
            $(".btn-save").on('click', function() {
                var selectedStatus = $("#requestStatus").val();
                // Send the ajax request
                $.ajax({
                    type: "POST",
                    url: "update-request.php",
                    data: {
                        request_id: requestId,
                        request_status: selectedStatus
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            alert(response.message);
                            console.log('Success:', response.message);
                            // Hiding the modal
                            $("#exampleModal").modal('hide');
                            
                            // Update the request status text and class dynamically
                            tdStatus.text(selectedStatus);
                            tdStatus.attr('class', 'font-weight-bold text-white px-3 py-1 rounded-2 request-' + selectedStatus);
                        } else {
                            alert('Error: ' + response.message);
                            console.log('Error:', response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });

        // Close Modal
        $(document).on('click', '.close-modal', function() {
            $("#exampleModal").modal('hide');
        });
    });
</script>

<?php require_once "../includes/footer.php"; ?>
