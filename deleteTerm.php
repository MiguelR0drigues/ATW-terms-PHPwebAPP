<?php

require 'functions.php';
require 'db.connection.php';
session_start();
isAdmin($_SESSION["type"]);

if(isset($_GET["id"])){
    $sql = "DELETE FROM `termos` WHERE id=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id=$_GET["id"];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            header("location: index.php");
        // Close statement
        mysqli_stmt_close($stmt);
        }
    }
}