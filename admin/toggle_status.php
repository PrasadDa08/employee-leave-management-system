<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
require_once "../includes/functions.php";

checkRole('admin');

$user_id = $_GET['user_id'];
$status = $_GET['status'];

/** @var mysqli $conn */
$stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");

$stmt->bind_param("si", $status, $user_id);

$stmt->execute();

if ($user_id == 'active') {
    addAuditLog(
        $conn,
        $_SESSION['user_id'],
        "Enabled user ID: " . $user_id
    );
} else {
    addAuditLog(
        $conn,
        $_SESSION['user_id'],
        "Disabled user ID: " . $user_id
    );
}

header("Location: users.php");
exit();
