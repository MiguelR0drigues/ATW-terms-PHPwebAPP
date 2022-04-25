<?php

session_start();
require_once("db.connection.php");
require 'functions.php';
$id= $_POST["id"];
$error_msg="";


if(empty(trim($_POST["description"]))){
    $error_msg="Empty field";
}else{
    // Prepare an update statement
    $sql = "UPDATE termos SET `description` = ?, `altDate` = current_timestamp() WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "si", $param_desc, $param_id);
        
        // Set parameters
        $param_desc = $_POST["description"];
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            header('location: term.php?id='.$id);
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
        }echo mysqli_error ($link);
    }
    $name=ownerNameByID($_SESSION["id"],$link);
    $date=date("Y-m-d H:i:s");
    $logFile = fopen("log_updates.txt", "a") or die("Unable to open file!");
    $txt="<".$name. " @ " . $date."> Updated the term with the id ".$_POST['id']." -- Change: Description -> ". $_POST["description"];;
    fwrite($logFile,$txt.PHP_EOL);
// Close connection
mysqli_close($link);