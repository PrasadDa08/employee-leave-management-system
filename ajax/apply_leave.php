<?php
header("Content-Type: application/json");
require_once "../includes/functions.php";
require_once "../config/database.php";
require_once "../includes/auth.php";
date_default_timezone_set('asia/kolkata');

checkRole('employee');

$leave_type_id = $_POST['leaveType'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];

$total_days = ((strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24)) + 1;

if ($start_date < date('Y-m-d')) {
    echo json_encode([
        "status" => false,
        "message" => 'Start dade cannot be before today'
    ]);
    exit();
}

if ($end_date < $start_date) {
    echo json_encode([
        "status" => false,
        "message" => 'End Date cannot be earlier and Start Date'
    ]);
    exit();
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
    echo json_encode([
        "status" => false,
        "message" => 'Insufficient leave balance'
    ]);
    exit();
}

$overlappingStmt = $conn->prepare("SELECT id FROM leave_requests WHERE employee_id = ? AND status IN('pending','approved') AND start_date <= ? AND end_date >= ?");

$overlappingStmt->bind_param('iss', $employee_id, $end_date, $start_date);
$overlappingStmt->execute();

$overlappingResult = $overlappingStmt->get_result();

if ($overlappingResult->num_rows > 0) {
    echo json_encode([
        "status" => false,
        "message" => 'Overlapping leave request exists'
    ]);
    exit();
}

$stmt1 = $conn->prepare("INSERT INTO leave_requests(employee_id, leave_type_id, start_date, end_date, total_days, reason) VALUES (?, ?, ?, ?, ?, ?)");

$stmt1->bind_param('iissis', $employee_id, $leave_type_id, $start_date, $end_date, $total_days, $reason);
$stmt1->execute();

addAuditLog(
    $conn,
    $_SESSION['user_id'],
    "Applied leave request ID: " . $conn->insert_id
);

echo json_encode([
    "status" => true,
    "message" => 'Leave Application submitted successfully'
]);
