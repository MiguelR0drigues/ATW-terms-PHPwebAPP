<?php
session_start();
include "db.connection.php";
include "functions.php";

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

$name=ownerNameByID($_SESSION["id"],$link);
$date=date("Y-m-d H:i:s");
$logFile = fopen("log_updates.txt", "a") or die("Unable to open file!");
$txt="<".$name. " @ " . $date."> Updated the term with the id ".$_GET['id']." -- Change: REVISED -> NOT REVISED";
fwrite($logFile,$txt.PHP_EOL);