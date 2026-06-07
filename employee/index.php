<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('employee');

$pending = 'pending';
$approved = 'approved';
$rejected = 'rejected';

/** @var mysqli $conn */

$stmt = $conn->prepare("SELECT id FROM employees WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

$totalRequestsStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE employee_id = ?");
$totalRequestsStmt->bind_param('i', $userData['id']);
$totalRequestsStmt->execute();
$totalRequests = $totalRequestsStmt->get_result()->fetch_assoc();

$approvedStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE employee_id = ? AND status = ?");
$approvedStmt->bind_param('is', $userData['id'], $approved);
$approvedStmt->execute();
$approvedRequests = $approvedStmt->get_result()->fetch_assoc();

$pendingStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE employee_id = ? AND status = ?");
$pendingStmt->bind_param('is', $userData['id'], $pending);
$pendingStmt->execute();
$pendingRequests = $pendingStmt->get_result()->fetch_assoc();

$rejectedStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE employee_id = ? AND status = ?");
$rejectedStmt->bind_param('is', $userData['id'], $rejected);
$rejectedStmt->execute();
$rejectedRequests = $rejectedStmt->get_result()->fetch_assoc();

$leaveBalanceStmt = $conn->prepare("SELECT lb.available_days, lt.leave_name FROM leave_balances lb INNER JOIN leave_types lt ON lb.leave_type_id = lt.id WHERE lb.employee_id = ?");
$leaveBalanceStmt->bind_param('i', $userData['id']);
$leaveBalanceStmt->execute();
$leaveBalances = $leaveBalanceStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <?php include_once "header.php" ?>
    <div class="container">
        <h3 class="text-center p-3 border-bottom border-5">Employee Dashboard</h3>
        <div class="row g-3">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Leave Requests</h5>
                        <p class="card-text"><?php echo $totalRequests['total'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Approved Leave Requests</h5>
                        <p class="card-text"><?php echo $approvedRequests['total'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rejected Leave Requests</h5>
                        <p class="card-text"><?php echo $rejectedRequests['total'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pending Leave Requests</h5>
                        <p class="card-text"><?php echo $pendingRequests['total'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Available Leave Balances</h5>
                        <?php while ($row = $leaveBalances->fetch_assoc()) { ?>
                            <p class="card-text"><?php echo $row['leave_name'] ?> : <span><?php echo $row['available_days'] ?> Days</span></p>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>