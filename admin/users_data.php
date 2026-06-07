<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('admin');

/** @var mysqli $conn */

$query = "SELECT u.id, u.email, e.mobile, u.role, u.status, e.id as employee_id, e.full_name, e.department, e.designation,  e.joining_date FROM users u LEFT JOIN employees e ON u.id = e.user_id WHERE u.role NOT IN ('admin', 'manager')";

$params = [];
$type = '';

if (!empty($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $query .= " AND (e.full_name LIKE ? OR e.id LIKE ? OR e.department LIKE ?)";

    $params[] = $search;
    $params[] = $search;
    $params[] = $search;
    $type .= 'sss';
}

$query .= " ORDER BY u.id DESC";


$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($type, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>View Users</title>
</head>

<body>
    <table class="table table-striped table-hover table-bordered text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Employee Id</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Department</th>
                <th scope="col">Designation</th>
                <th scope="col">Role</th>
                <th scope="col">Joining Date</th>
                <th scope="col">status</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sr = 1;
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?php echo $sr++ ?></th>
                    <td><?php echo $row['full_name'] ?></td>
                    <td><?php echo $row['employee_id'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['mobile'] ?></td>
                    <td><?php echo $row['department'] ?></td>
                    <td><?php echo $row['designation'] ?></td>
                    <td><?php echo $row['role'] ?></td>
                    <td><?php echo $row['joining_date'] ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td><button class="btn btn-primary btn-sm" onclick="window.location.href = 'edit_user.php?user_id=<?php echo $row['id'] ?>'">Edit</button>
                        <?php if ($row['status'] == 'active') { ?>
                            <a href="toggle_status.php?user_id=<?php echo $row['id']; ?>&status=inactive"
                                class="btn btn-danger btn-sm">
                                Disable
                            </a>
                        <?php } else { ?>
                            <a href="toggle_status.php?user_id=<?php echo $row['id']; ?>&status=active"
                                class="btn btn-success btn-sm">
                                Enable
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>