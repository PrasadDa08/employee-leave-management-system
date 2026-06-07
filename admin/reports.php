<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('admin');


/** @var mysqli $conn */
$query = "SELECT lr.*, e.full_name, e.department, lt.leave_name FROM leave_requests lr INNER JOIN employees e ON e.id = lr.employee_id INNER JOIN leave_types lt ON lt.id = lr.leave_type_id WHERE 1";

$params = [];
$types = "";


if (!empty($_GET['name'])) {
    $query .= " AND e.full_name LIKE ?";
    $params[] = "%" . $_GET['name'] . "%";
    $types .= "s";
}

if (!empty($_GET['department'])) {
    $query .= " AND e.department LIKE ?";
    $params[] = "%" . $_GET['department'] . "%";
    $types .= "s";
}

if (!empty($_GET['leave_type'])) {
    if ($_GET['leave_type'] != 'all') {
        $query .= " AND lr.leave_type_id = ?";
        $params[] = $_GET['leave_type'];
        $types .= "i";
    } else {
        $query .= " AND 1";
    }
}

if (!empty($_GET['status'])) {
    if ($_GET['status'] != 'all') {
        $query .= " AND lr.status = ?";
        $params[] = $_GET['status'];
        $types .= "s";
    } else {
        $query .= " AND 1";
    }
}

if (!empty($_GET['from_date'])) {
    $query .= " AND lr.start_date >= ?";
    $params[] = $_GET['from_date'];
    $types .= "s";
}

if (!empty($_GET['to_date'])) {
    $query .= " AND lr.end_date <= ?";
    $params[] = $_GET['to_date'];
    $types .= "s";
}

$query .= " ORDER BY lr.created_at DESC";


$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

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

    <form method="GET">
        <div class="row">
            <div class="mb-3 col-12">
                <label for="name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>">
            </div>
            <div class="mb-3 col-12">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo isset($_GET['department']) ? $_GET['department'] : '' ?>">
            </div>
            <div class="mb-3 col-4">
                <label for="leave_type" class="form-label">Leave Type</label>
                <select class="form-select" id="leave_type" name="leave_type">
                    <option value="all" <?php echo isset($_GET['leave_type']) && ($_GET['leave_type'] == 'all') ? 'selected' : ''?>>All</option>
                    <?php
                    $stmt2 = $conn->prepare("SELECT * FROM leave_types");
                    $stmt2->execute();
                    $leave_types = $stmt2->get_result();

                    while ($row = $leave_types->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['leave_type']) && ($_GET['leave_type'] == $row['id']) ? 'selected' : ''?>><?php echo $row['leave_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3 col-3">
                <label for="status" class="form-label">Leave Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="all" <?php echo isset($_GET['status']) && ($_GET['status'] == 'all') ? 'selected' : ''?>>All</option>
                    <option value="pending" <?php echo isset($_GET['status']) && ($_GET['status'] == 'pending') ? 'selected' : ''?>>Pending</option>
                    <option value="approved" <?php echo isset($_GET['status']) && ($_GET['status'] == 'approved') ? 'selected' : ''?>>Approved</option>
                    <option value="rejected" <?php echo isset($_GET['status']) && ($_GET['status'] == 'rejected') ? 'selected' : ''?>>Rejected</option>
                </select>
            </div>
            <div class="mb-3 col-6">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>">
            </div>
            <div class="mb-3 col-6">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>">
            </div>

        </div>

        <button type="submit" class="btn btn-primary" name="submit">Submit</button>

    </form>


    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Employee Id</th>
                <th scope="col">Department</th>
                <th scope="col">Leave Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Days</th>
                <th scope="col">Status</th>
                <th scope="col">Approved By</th>
                <th scope="col">Approval Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows == 0) {
                echo "<tr><td colspan='11'>No data Found</td></tr>";
            } else {
                $sr = 1;
                while ($row1 = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $sr++ ?></th>
                        <td><?php echo $row1['full_name'] ?></td>
                        <td><?php echo $row1['employee_id'] ?></td>
                        <td><?php echo $row1['department'] ?></td>
                        <td><?php echo $row1['leave_name'] ?></td>
                        <td><?php echo $row1['start_date'] ?></td>
                        <td><?php echo $row1['end_date'] ?></td>
                        <td><?php echo $row1['total_days'] ?></td>
                        <td><?php echo $row1['status'] ?></td>
                        <td><?php echo $row1['approved_by'] ?></td>
                        <td><?php echo $row1['approved_at'] ?></td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</body>

</html>