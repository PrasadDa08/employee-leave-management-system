<?php
$host = "localhost:8889";
$username = "root";
$password = "root";
$database = "employee_leave_management";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed");
}
