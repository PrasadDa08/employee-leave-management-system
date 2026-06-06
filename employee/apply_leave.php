<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
date_default_timezone_set('asia/kolkata');

checkRole('employee');

if (isset($_POST['submit'])) {

    $leave_type_id = $_POST['leaveType'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    $total_days = ((strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24)) + 1;

    if ($start_date < date('Y-m-d')) {
        die("Start date cannot be earlier than today");
    }

    if ($end_date < $start_date) {
        die("End Date cannot be earlier and Start Date");
    }



    /** @var mysqli $conn */

    $stmt = $conn->prepare("SELECT id FROM employees WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();

    $employee_details = $stmt->get_result()->fetch_assoc();
    $employee_id = $employee_details['id'];

    $availableBalanceStmt = $conn->prepare("SELECT available_days FROM leave_balances WHERE employee_id = ? AND leave_type_id = ?");
    $availableBalanceStmt->bind_param("ii", $employee_id, $leave_type_id);
    $availableBalanceStmt->execute();
    $leaveBalance = $availableBalanceStmt->get_result()->fetch_assoc();

    if ($leaveBalance['available_days'] < $total_days) {
        die("Insufficient leave balance");
    }

    $overlappingStmt = $conn->prepare("SELECT id FROM leave_requests WHERE employee_id = ? AND status IN('pending','approved') AND start_date <= ? AND end_date >= ?");

    $overlappingStmt->bind_param('iss', $employee_id, $end_date, $start_date);
    $overlappingStmt->execute();

    $overlappingResult = $overlappingStmt->get_result();

    if ($overlappingResult->num_rows > 0) {
        die("Overlapping leave request exists");
    }

    $stmt1 = $conn->prepare("INSERT INTO leave_requests(employee_id, leave_type_id, start_date, end_date, total_days, reason) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt1->bind_param('iissis', $employee_id, $leave_type_id, $start_date, $end_date, $total_days, $reason);
    $stmt1->execute();

    echo "<script>alert('Leave Application submitted successfully'); window.location.href= leave_history.php</script>";
}
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
        <form method="POST">
            <div class="row">
                <div class="mb-3 col-4">
                    <label for="leaveType" class="form-label">Leave Type</label>
                    <select class="form-select" id="leaveType" name="leaveType">
                        <option value="">Select Leave Type</option>
                        <?php
                        $stmt2 = $conn->prepare("SELECT * FROM leave_types");
                        $stmt2->execute();
                        $leave_types = $stmt2->get_result();

                        while ($row = $leave_types->fetch_assoc()) {
                        ?>
                            <option value=<?php echo $row['id'] ?>><?php echo $row['leave_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3 col-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="start_date">
                </div>
                <div class="mb-3 col-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                </div>
                <div class="mb-3 col-12">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea class="form-control" id="reason" name="reason"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

        </form>
    </div>
</body>

</html>