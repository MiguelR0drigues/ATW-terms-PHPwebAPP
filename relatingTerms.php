<?php

require "functions.php";
include("termsInfo.php");


session_start();
if((isAccountReady() && isAdmin($_SESSION["type"]))){
    header("location: index.php");
}

$selectQuery = "SELECT title FROM termos";
if ($stmt = mysqli_prepare($link, $selectQuery)) {
    // Bind variables to the prepared statement as parameters
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $title);
        if (mysqli_stmt_fetch($stmt))
            $terms=$title;
    } else {
        echo mysqli_error($link);
    }
} else {
    echo mysqli_error($link);
}// Close statement
mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relating Terms</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <?php
        if(isset($_GET["error"]) && $_GET["error"] == 1){
            echo '<div class="alert alert-danger" role="alert" style="width: 40%; margin:auto;margin-top:1%">';
                echo ' Cannot relate the term with himself!';
            echo '</div>';
        }
        if(isset($_GET["error"]) && $_GET["error"] == 2){
            echo '<div class="alert alert-danger" role="alert" style="width: 40%; margin:auto;margin-top:1%">';
                echo ' These terms are already related!';
            echo '</div>';
        }
    ?>
    <div class=" d-flex aligns-items-center justify-content-center">
        <form method="POST" action="relatingTermsAction.php">
            <span>Father term:</span>
            <select name="fatherTerm" id="fatherTerm" class="form-select">
            <?php echo $deleteMsg??''; ?>
            <?php
                if(is_array($fetchData)){      
                $sn=1;
                foreach($fetchData as $data){
                    ?>
                    <option value=" <?php echo $data["id"]?> ";> <?php echo $data["title"]?></option>
                    <?php
                $sn++;}}else{ ?>
                <?php echo $fetchData; ?>
                <?php
                }?>
            </select>
            <span>Children term:</span>
            <select name="SonTerm" id="SonTerm" class="form-select">
            <?php echo $deleteMsg??''; ?>
            <?php
                if(is_array($fetchData)){      
                $sn=1;
                foreach($fetchData as $data){
                    ?>
                    <option value=" <?php echo $data["id"]?> ";> <?php echo $data["title"]?></option>
                    <?php
                $sn++;}}else{ ?>
                <?php echo $fetchData; ?>
                <?php
                }?>
            </select><br>
            <button type="submit" class="btn btn-primary">SUBMITE</button>

        </form>
    </div>
</body>
</html>