<?php
header("Content-Type: application/json");
require_once "../config/database.php";
require_once "../includes/auth.php";
date_default_timezone_set('asia/kolkata');

checkRole('manager');

$request_id = $_POST['request_id'];
$remarks = $_POST['remarks'];


/** @var mysqli $conn */
$stmt = $conn->prepare("UPDATE leave_requests SET status = 'rejected', approved_by = ?, manager_remarks = ?, approved_at = NOW() WHERE id = ?");
$stmt->bind_param('isi', $_SESSION['user_id'], $remarks, $request_id);
$stmt->execute();

echo json_encode([
    'status' => true,
    'message' => 'Leave Request rejected',
]);

exit();

?>

