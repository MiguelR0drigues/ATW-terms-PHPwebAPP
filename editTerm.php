<?php

session_start();
require_once("db.connection.php");
require 'functions.php';

if(isAccountReady()){
    if(!(isAdmin($_SESSION["type"])||isOwner($_SESSION["id"],$_GET["id"],$link,))){
        header('location: index.php');
    }
}
$termID = $_GET["id"];
$selectQuery = "SELECT title,`description`,`owner`,pubDate,revDate,altDate FROM termos WHERE id=?";
if ($stmt = mysqli_prepare($link, $selectQuery)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $termID);
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
    <form action="editTermAction.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
    <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="text" class="form-control" value="<?php echo $result['title']?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <input class="form-control" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
</body>
</html>