<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('admin');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $joining_date = $_POST['joining'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    /** @var mysqli $conn */
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO users(email, password, role, status) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $email, $hashedPassword, $role, $status);
        $stmt->execute();

        $user_id = $conn->insert_id;;

        $stmt2 = $conn->prepare("INSERT INTO employees(user_id, full_name, mobile, department, designation, joining_date) VALUES (?,?,?,?,?,?)");
        $stmt2->bind_param('isssss', $user_id, $name, $mobile, $department, $designation, $joining_date);
        $stmt2->execute();

        $employee_id = $conn->insert_id;

        $stmt3 = $conn->prepare("SELECT id, leave_name, default_allocation FROM leave_types");
        $stmt3->execute();

        $leave_types = $stmt3->get_result();

        while($row = $leave_types->fetch_assoc()){
        $stmt4 = $conn->prepare("INSERT INTO leave_balances(employee_id, leave_type_id, available_days) VALUES(?,?,?)");
        $stmt4->bind_param('iii', $employee_id, $row['id'], $row['default_allocation']);
        $stmt4->execute();
        }

        $conn->commit();
        echo "<script> alert('Employee created successfully'); window.location.href = 'users.php'; </script>";
    } catch (Exception $e) {

        /** @var mysqli $conn */
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
    <title>Document</title>
</head>

<body>
    <div class="container">
        <form method="POST">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3 col-12">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                </div>
                <div class="mb-3 col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3 col-12">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" class="form-control" id="mobile" name="mobile">
                </div>
                <div class="mb-3 col-12">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" class="form-control" id="department" name="department">
                </div>
                <div class="mb-3 col-12">
                    <label for="designation" class="form-label">designation</label>
                    <input type="text" class="form-control" id="designation" name="designation">
                </div>
                <div class="mb-3 col-6">
                    <label for="joining" class="form-label">Joining Date</label>
                    <input type="date" class="form-control" id="joining" name="joining">
                </div>
                <div class="mb-3 col-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">Select Role</option>
                        <option value="employee">Employee</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div class="mb-3 col-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

        </form>
    </div>
</body>

</html>