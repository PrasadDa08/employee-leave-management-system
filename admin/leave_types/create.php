<?php
require_once "../../config/database.php";
require_once "../../includes/auth.php";

checkRole('admin');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $allocation = $_POST['allocation'];


    /** @var mysqli $conn */

    $stmt = $conn->prepare("INSERT INTO leave_types(leave_name, default_allocation) VALUES (?,?)");
    $stmt->bind_param('si', $name, $allocation);
    $stmt->execute();

    echo "<script> alert('Leave Type added successfully'); window.location.href = 'view.php'; </script>";
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
    <?php include_once "header.php" ?>
    <div class="container">
        <h3 class="text-center p-3 border-bottom border-5">Employee Update Form</h3>
        <form method="POST">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="name" class="form-label">Leave Type</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3 col-12">
                    <label for="attocation" class="form-label">Allocation</label>
                    <input type="number" class="form-control" id="allocation" name="allocation">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

        </form>
    </div>
</body>

</html>