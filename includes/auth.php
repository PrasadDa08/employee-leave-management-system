<?php
require_once "session.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

function checkRole(string $role){
    if(!isset($_SESSION['role']) || $_SESSION['role'] != $role){
        header("Location: ../login.php");
        exit();
    }

}



?>