<?php

include "db.connection.php";

$updateQuery = "UPDATE termos SET revisto=0 , revDate=null WHERE id=?";
if ($stmt = mysqli_prepare($link, $updateQuery)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
    if (mysqli_stmt_execute($stmt)) {
        header("location: termsManagement.php");
    } else {
        echo mysqli_error($link);
    }
} else {
    echo mysqli_error($link);
}