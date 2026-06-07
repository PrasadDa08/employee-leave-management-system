<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
require_once "../includes/functions.php";

checkRole('admin');

$user_id = $_GET['user_id'];

/** @var mysqli $conn */
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? ");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$userResults = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("SELECT * FROM employees WHERE user_id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();

$employeeResults = $stmt2->get_result()->fetch_assoc();


if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $joining_date = $_POST['joining'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $conn->begin_transaction();

    try {
        $stmt3 = $conn->prepare("UPDATE users SET email = ?, role = ? WHERE id = ?");
        $stmt3->bind_param('ssi', $email, $role, $user_id);
        $stmt3->execute();

        $stmt4 = $conn->prepare("UPDATE employees SET full_name = ?, mobile = ?, department = ?, designation = ?, joining_date = ? WHERE user_id = ?");
        $stmt4->bind_param('sssssi', $name, $mobile, $department, $designation, $joining_date, $user_id);
        $stmt4->execute();

        addAuditLog(
            $conn,
            $_SESSION['user_id'],
            "Updated employee: " . $name
        );

        $conn->commit();
        echo "<script> alert('Employee details updated successfully'); window.location.href = 'users.php'; </script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Failed" . $e->getMessage();
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Admin Panel</title>
</head>

<body>
    <?php include_once "header.php" ?>
    <div class="container">
        <h3 class="text-center p-3 border-bottom border-5">Employee Update Form</h3>
        <form method="POST">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value=<?php echo $employeeResults['full_name'] ?> required>
                </div>
                <div class="mb-3 col-12">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value=<?php echo $userResults['email'] ?> required>
                </div>
                <div class="mb-3 col-12">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" class="form-control" id="mobile" name="mobile" value=<?php echo $employeeResults['mobile'] ?> required>
                </div>
                <div class="mb-3 col-12">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" class="form-control" id="department" name="department" value=<?php echo $employeeResults['department'] ?> required>
                </div>
                <div class="mb-3 col-12">
                    <label for="designation" class="form-label">designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" value=<?php echo $employeeResults['designation'] ?> required>
                </div>
                <div class="mb-3 col-6">
                    <label for="joining" class="form-label">Joining Date</label>
                    <input type="date" class="form-control" id="joining" name="joining" value=<?php echo $employeeResults['joining_date'] ?> required>
                </div>
                <div class="mb-3 col-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="employee" <?php echo $userResults['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
                        <option value="manager" <?php echo $userResults['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                    </select>
                </div>
                <div class="mb-3 col-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" <?php echo $userResults['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?php echo $userResults['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="update">Update</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>

        </form>
    </div>
</body>

</html>