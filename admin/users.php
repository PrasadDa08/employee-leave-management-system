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
    <title>View Users</title>
</head>

<body>
    <form id="searchForm">
        <div class="row">
            <div class="mb-3 col-12">
                <label for="search" class="form-label">Search</label>
                <input type="search" class="form-control" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="search">Search</button>

    </form>

    <div id="tableContainer">

    </div>
</body>
<script>
    function loadUsers(){
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