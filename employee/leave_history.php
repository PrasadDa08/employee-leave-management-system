<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('employee');

/** @var mysqli $conn */

$stmt = $conn->prepare("SELECT id FROM employees WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("SELECT lr.*, lt.leave_name FROM leave_requests lr LEFT JOIN leave_types lt ON lr.leave_type_id = lt.id WHERE lr.employee_id = ?");
$stmt2->bind_param('i', $result['id']);
$stmt2->execute();

$result2 = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>View Users</title>
</head>

<body>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Request Id</th>
                <th scope="col">Leave Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Days</th>
                <th scope="col">Status</th>
                <th scope="col">Manager Remarks</th>
                <th scope="col">Applied Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sr = 1;
            while ($row = $result2->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?php echo $sr++ ?></th>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['leave_name'] ?></td>
                    <td><?php echo $row['start_date'] ?></td>
                    <td><?php echo $row['end_date'] ?></td>
                    <td><?php echo $row['total_days'] ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td><?php echo $row['manager_remarks'] ?></td>
                    <td><?php echo $row['created_at'] ?></td>
                    <!-- <td><button class="btn btn-primary" onclick="window.location.href = 'edit_user.php?user_id=<?php //echo $row['id'] 
                                                                                                                    ?>'">Edit</button></td> -->
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>