<?php
require_once "../../config/database.php";
require_once "../../includes/auth.php";

checkRole('admin');

$leave_id = $_GET['leave_id'];

/** @var mysqli $conn */
$stmt = $conn->prepare("SELECT * FROM leave_types WHERE id = ? ");
$stmt->bind_param("i", $leave_id);
$stmt->execute();

$leaveResults = $stmt->get_result()->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $allocation = $_POST['allocation'];

    $stmt2 = $conn->prepare("UPDATE leave_types SET leave_name = ?, default_allocation = ? WHERE id = ?");
    $stmt2->bind_param('sii', $name, $allocation, $leave_id);
    $stmt2->execute();

    echo "<script> alert('Leaves modified successfully'); window.location.href = 'view.php'; </script>";
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
                    <label for="name" class="form-label">Leave Type</label>
                    <input type="text" class="form-control" id="name" name="name" value=<?php echo $leaveResults['leave_name']?>>
                </div>
                <div class="mb-3 col-12">
                    <label for="attocation" class="form-label">Allocation</label>
                    <input type="number" class="form-control" id="allocation" name="allocation" value=<?php echo $leaveResults['default_allocation']?>>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="update">Update</button>

        </form>
    </div>
</body>

</html>