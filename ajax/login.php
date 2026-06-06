<?php
require "../config/database.php";
require_once "../includes/session.php";


if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "" || $password == "") {
        echo "<script>alert('Email or password cannot be empty'); window.location.href = '../login.php'</script>";
    }

     /** @var mysqli $conn */

    $stmt = $conn->prepare("SELECT id, username, email, role, password, status FROM users WHERE email = ? LIMIT 1");

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 0) {
        echo "<script>alert('User not found'); window.location.href = '../login.php';</script>";
        
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        echo "<script>alert('Invalid credentials'); window.location.href = '../login.php';</script>";
        
    }

    if($user['status'] != 'active'){
        die("Your account is inactive");
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    if($user['role'] == 'admin'){
        header("Location: ../admin/index.php");
        exit();
    }

    if($user['role'] == 'manager'){
        header("Location: ../manager/index.php");
        exit();
    }

    if($user['role'] == 'employee'){
        header("Location: ../employee/index.php");
        exit();
    }

}
