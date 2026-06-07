<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('employee');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>

<body>
    <?php include_once "header.php" ?>
    <div class="container">
        <h3 class="text-center p-3 border-bottom border-5">Apply Leave Form</h3>
        <form id="leaveForm">
            <div class="row">
                <div class="mb-3 col-4">
                    <label for="leaveType" class="form-label">Leave Type</label>
                    <select class="form-select" id="leaveType" name="leaveType">
                        <option value="">Select Leave Type</option>
                        <?php
                        /** @var mysqli $conn */
                        $stmt = $conn->prepare("SELECT * FROM leave_types");
                        $stmt->execute();
                        $leave_types = $stmt->get_result();

                        while ($row = $leave_types->fetch_assoc()) {
                        ?>
                            <option value=<?php echo $row['id'] ?>><?php echo $row['leave_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3 col-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="start_date">
                </div>
                <div class="mb-3 col-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                </div>
                <div class="mb-3 col-12">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea class="form-control" id="reason" name="reason"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

        </form>
    </div>
</body>
<script>
    $("#leaveForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "../ajax/apply_leave.php",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    $("#leaveForm")[0].reset();
                } else {
                    alert(response.message);
                }
            }
        })
    })
</script>

</html>