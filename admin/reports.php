<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Admin Panel</title>
</head>

<body>
    <?php include_once "header.php" ?>
    <h3 class="text-center p-3 border-bottom border-5">Reports</h3>
    <form id="reportForm" class="p-3">
        <div class="row">
            <div class="mb-3 col-4">
                <label for="name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>">
            </div>
            <div class="mb-3 col-4">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo isset($_GET['department']) ? $_GET['department'] : '' ?>">
            </div>
            <div class="mb-3 col-4">
                <label for="leave_type" class="form-label">Leave Type</label>
                <select class="form-select" id="leave_type" name="leave_type">
                    <option value="all" <?php echo isset($_GET['leave_type']) && ($_GET['leave_type'] == 'all') ? 'selected' : '' ?>>All</option>
                    <?php
                    /** @var mysqli $conn */
                    $stmt = $conn->prepare("SELECT * FROM leave_types");
                    $stmt->execute();
                    $leave_types = $stmt->get_result();

                    while ($row = $leave_types->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['leave_type']) && ($_GET['leave_type'] == $row['id']) ? 'selected' : '' ?>><?php echo $row['leave_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label for="status" class="form-label">Leave Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="all" <?php echo isset($_GET['status']) && ($_GET['status'] == 'all') ? 'selected' : '' ?>>All</option>
                    <option value="pending" <?php echo isset($_GET['status']) && ($_GET['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?php echo isset($_GET['status']) && ($_GET['status'] == 'approved') ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?php echo isset($_GET['status']) && ($_GET['status'] == 'rejected') ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>">
            </div>
            <div class="mb-3 col-4">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>">
            </div>

        </div>

        <button type="submit" class="btn btn-primary ms-auto" name="submit">Filter</button>

    </form>

    <div id="reportContainer" class="table-responsive">

    </div>
</body>
<script>
    function loadReport() {
        $.ajax({
            url: "report_data.php",
            method: 'GET',
            data: $("#reportForm").serialize(),

            success: function(response) {
                $("#reportContainer").html(response);
            }
        })
    }

    loadReport()
    $("#reportForm").submit(function(e) {
        e.preventDefault();
        loadReport()

    })
</script>

</html>