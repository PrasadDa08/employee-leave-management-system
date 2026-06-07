<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('manager');

$pending = 'pending';
$approved = 'approved';
$rejected = 'rejected';

/** @var mysqli $conn */

$totalRequestsStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests");
$totalRequestsStmt->execute();
$totalRequests = $totalRequestsStmt->get_result()->fetch_assoc();

$approvedStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE status = ?");
$approvedStmt->bind_param('s', $approved);
$approvedStmt->execute();
$approvedRequests = $approvedStmt->get_result()->fetch_assoc();

$pendingStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE status = ?");
$pendingStmt->bind_param('s', $pending);
$pendingStmt->execute();
$pendingRequests = $pendingStmt->get_result()->fetch_assoc();

$rejectedStmt = $conn->prepare("SELECT count(*) as total FROM leave_requests WHERE status = ?");
$rejectedStmt->bind_param('s', $rejected);
$rejectedStmt->execute();
$rejectedRequests = $rejectedStmt->get_result()->fetch_assoc();

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
    <div class="container">
        <div class="row g-3  mx-auto">
            <div class="card col-3 mx-3">
                <div class="card-body">
                    <h5 class="card-title">Total Leave Requests</h5>
                    <p class="card-text"><?php echo $totalRequests['total'] ?></p>
                </div>
            </div>

            <div class="card col-3 mx-3">
                <div class="card-body">
                    <h5 class="card-title">Approved Leave Requests</h5>
                    <p class="card-text"><?php echo $approvedRequests['total'] ?></p>
                </div>
            </div>

            <div class="card col-3 mx-3">
                <div class="card-body">
                    <h5 class="card-title">Rejected Leave Requests</h5>
                    <p class="card-text"><?php echo $rejectedRequests['total'] ?></p>
                </div>
            </div>

            <div class="card col-3 mx-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Leave Requests</h5>
                    <p class="card-text"><?php echo $pendingRequests['total'] ?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>