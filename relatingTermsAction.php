<?php

session_start();
require "functions.php";
require "db.connection.php";
$father=$_POST["fatherTerm"];
$son =$_POST["SonTerm"];
if (empty($father) || empty($son)){
    header("location: relatingTerms.php");
    exit;
}

if($father == $son){
    header("location: relatingTerms.php?error=1");
    exit;
}

if(areTermsRelated($father,$son,$link)){
    header("location: relatingTerms.php?error=2");
    exit;
}

// Prepare an insert statement
$sql = "INSERT INTO relacao (pai,filho) VALUES (?,?)";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, 'ii', $father,$son);

    

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {

        header("location: terms.php");
    } else {
        echo "QUERY:::::Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}