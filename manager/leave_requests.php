<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('manager');

/** @var mysqli $conn */

$stmt = $conn->prepare("SELECT lr.*, e.full_name, e.department, u.email, lt.leave_name FROM leave_requests lr INNER JOIN employees e ON lr.employee_id = e.id INNER JOIN users u ON u.id = e.user_id INNER JOIN leave_types lt ON lr.leave_type_id = lt.id WHERE lr.status = 'pending' ORDER BY lr.created_at DESC");

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>View Users</title>
</head>

<body>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Department</th>
                <th scope="col">Leave Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Days</th>
                <th scope="col">Reason</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sr = 1;
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?php echo $sr++ ?></th>
                    <td><?php echo $row['full_name'] ?></td>
                    <td><?php echo $row['department'] ?></td>
                    <td><?php echo $row['leave_name'] ?></td>
                    <td><?php echo $row['start_date'] ?></td>
                    <td><?php echo $row['end_date'] ?></td>
                    <td><?php echo $row['total_days'] ?></td>
                    <td><?php echo $row['reason'] ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td><button class="btn btn-success approve-btn" data-id="<?php echo $row['id'] ?>">Approve</button>
                        <button class="btn btn-danger reject-btn" data-id="<?php echo $row['id'] ?>">Reject</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
<script>
    $(document).on('click', '.approve-btn', function() {
        let requestId = $(this).data('id');
        let row = $(this).closest('tr');

        $.ajax({
            url: '../ajax/approve_request.php',
            type: 'POST',
            data: {
                request_id: requestId
            },
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    row.remove();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("Something went wrong");
            }
        })
    })

    $(document).on('click', '.reject-btn', function() {
        let requestId = $(this).data('id');
        let row = $(this).closest('tr');
        let remarks = prompt('Enter rejection remarks');

        if (remarks === null) {
            return;
        }

        if (remarks == '') {
            alert("Manager remarks are required");
            return;
        }

        $.ajax({
            url: '../ajax/reject_request.php',
            method: 'POST',
            data: {
                request_id: requestId,
                remarks: remarks
            },
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    row.remove();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("Something went wrong");
            }
        })
    })
</script>

</html>