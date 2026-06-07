<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('admin');

$user_id = $_GET['user_id'];
$status = $_GET['status'];

/** @var mysqli $conn */
$stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");

$stmt->bind_param("si", $status, $user_id);

$stmt->execute();

header("Location: users.php");
exit();