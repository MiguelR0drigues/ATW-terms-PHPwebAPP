<?php
session_start();
require 'functions.php';
require 'db.connection.php';
isAccountReady();

$selectQuery = "SELECT title,`description`,`owner`,pubDate,revDate,altDate FROM termos WHERE id=?";
if ($stmt = mysqli_prepare($link, $selectQuery)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $title,$description,$owner,$pubDate,$revDate,$altDate);
        if (mysqli_stmt_fetch($stmt))
            $result['title']=$title;
            $result['description']=$description;
            $result['owner']=$owner;
            $result['pubDate']=$pubDate;
            $result['revDate']=$revDate;
            $result['altDate']=$altDate;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title><?php echo $result['title']?></title>
</head>
<body>
    <div class="position-absolute top-0 start-50 translate-middle-x card" style="width: 30rem; margin-top: 5%">
        <div class="card-header"  style="display: flex; justify-content: space-between;">
            <p><?php echo $result['title'] ??''; ?></p>
            <p style="text-align: end;"><?php echo (ownerNameByID($result['owner'],$link)) ??'Unknown'; ?></p>
        </div> 
        <div class="card-body">
            <p class="card-text"><?php echo $result['description']??''; ?></p>
        <div style="display: flex; justify-content: space-between; margin-top:3rem">
            <h6 class="" style="text-align: end; font-size:small;color:grey;"><?php echo $result['pubDate']??''; ?></h6>
            <?php
            if(isAdmin($_SESSION["type"])|| isOwner($_SESSION["id"], $_GET["id"],$link)){
                echo '<div>';
                echo '<a href="editTerm.php?id=',$_GET["id"],'" class="card-link" style="font-size:small;">Edit</a>';
                echo '<a href="deleteTerm.php?id=',$_GET["id"],'" class="card-link" style="font-size:small;">Delete</a>';
                echo '</div>';   
            }
            ?>
        </div>
        </div>
    </div>
</body>
</html>
