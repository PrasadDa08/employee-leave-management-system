<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
date_default_timezone_set('asia/kolkata');

checkRole('manager');

$request_id = $_GET['request_id'];


if (isset($_POST['submit'])) {

    $remarks = $_POST['remarks'];

    if(trim($remarks) == ""){
    echo "<script>alert('Manager remarks are required'); window.history.back();</script>";
    exit();
}

    /** @var mysqli $conn */
    $stmt = $conn->prepare("UPDATE leave_requests SET status = 'rejected', approved_by = ?, manager_remarks = ?, approved_at = NOW() WHERE id = ?");
    $stmt->bind_param('isi', $_SESSION['user_id'], $remarks, $request_id);
    $stmt->execute();

    echo "<script>alert('Leave Request rejected'); window.location.href='leave_requests.php';</script>";
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
                <div class="mx-auto col-4">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

        </form>
    </div>
</body>

</html>