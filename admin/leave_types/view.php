<?php
require_once "../../config/database.php";
require_once "../../includes/auth.php";

checkRole('admin');

/** @var mysqli $conn */

$stmt = $conn->prepare("SELECT id, leave_name, default_allocation FROM leave_types");

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
    <title>Admin Panel</title>
</head>

<body>
    <?php include_once "header.php" ?>
    <h3 class="text-center p-3 border-bottom border-5">Alloted Leaves List</h3>
    <table class="table table-sm table-striped table-bordered table-hover mt-3 text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Leave Type</th>
                <th scope="col">Allocated Leaves/year</th>
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
                    <td><?php echo $row['leave_name'] ?></td>
                    <td><?php echo $row['default_allocation'] ?></td>
                    <td><button class="btn btn-primary btn-sm" onclick="window.location.href = 'edit.php?leave_id=<?php echo $row['id'] ?>'">Edit</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>