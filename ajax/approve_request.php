<?php
header('Content-Type: application/json');
require_once "../config/database.php";
require_once "../includes/auth.php";
date_default_timezone_set('asia/kolkata');

checkRole('manager');

$request_id = $_POST['request_id'];

/** @var mysqli $conn */

$stmt = $conn->prepare("SELECT employee_id, leave_type_id, total_days FROM leave_requests WHERE id = ?");
$stmt->bind_param('i', $request_id);
$stmt->execute();

$results = $stmt->get_result()->fetch_assoc();

$employee_id = $results['employee_id'];
$leave_type_id = $results['leave_type_id'];
$total_days = $results['total_days'];

$conn->begin_transaction();

try{

    $stmt2 = $conn->prepare("UPDATE leave_requests SET status = 'approved', approved_by = ?, approved_at = NOW() WHERE id = ?");
    $stmt2->bind_param('ii', $_SESSION['user_id'], $request_id);
    $stmt2->execute();

    $stmt3 = $conn->prepare("UPDATE leave_balances SET available_days = available_days - ? WHERE employee_id = ? AND leave_type_id = ?");
    $stmt3->bind_param('iii', $total_days, $employee_id, $leave_type_id);
    $stmt3->execute();

    $conn->commit();

    echo json_encode(
        [
            "status" => true,
            "message" => "Leave approved successfully"
        ]
    );
    exit();

}catch(Exception $e){
    $conn->rollback();
     echo json_encode(
        [
            "status" => false,
            "message" => "Failed to approve leave"
        ]
    );
    exit();
}



?>