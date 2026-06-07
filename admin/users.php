<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

checkRole('admin');

/** @var mysqli $conn */


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

    <h3 class="text-center p-3 border-bottom border-5">Employees List</h3>
    <div class="d-flex justify-content-between mt-4">
        <a class="btn btn-primary ms-2" href="create_users.php">Add Employees</a>
        <form id="searchForm">
            <div class="row">
                <div class="col-8">
                    <input type="search" class="form-control" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Name/ID/Department">
                </div>
                <button type="submit" class="btn btn-primary col-3 " name="search">Search</button>
            </div>
        </form>
    </div>

    <div id="tableContainer" class="table-responsive mt-3">

    </div>
</body>
<script>
    function loadUsers() {
        $.ajax({
            url: 'users_data.php',
            method: 'GET',
            data: $("#searchForm").serialize(),

            success: function(response) {
                $("#tableContainer").html(response)
            }
        })
    }

    loadUsers();

    $("#searchForm").submit(function(e) {
        e.preventDefault();
        loadUsers();
    })
</script>

</html>