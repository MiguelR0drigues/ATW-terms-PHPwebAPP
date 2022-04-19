<?php
session_start();
require 'functions.php';
require 'db.connection.php';

$term=jajaja($link,$_GET["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title><?php echo $_GET["id"]?></title>
</head>
<body>
    <div class="card" style="width: 30rem;">
        <div class="card-header"  style="display: flex; justify-content: space-between;">
            <p><?php echo $title ??''; ?></p>
            <p style="text-align: end;"><?php echo $term['title']??'Unknown'; ?></p>
        </div> 
        <div class="card-body">
            <p class="card-text"><?php echo $term['description']??''; ?></p>
        <div style="display: flex; justify-content: space-between; margin-top:3rem">
            <h6 class="" style="text-align: end; font-size:small;color:grey;"><?php echo $term['pubDate']??''; ?></h6>
            <?php
            if(isAdmin($_SESSION["type"])|| isOwner($_SESSION["id"], $_GET["id"],$link)){
                echo '<div>';
                echo '<a href="#" class="card-link" style="font-size:small;">Edit</a>';
                echo '<a href="deleteTerm.php?id=',$_GET["id"],'" class="card-link" style="font-size:small;">Delete</a>';
                echo '</div>';   
            }
            ?>
        </div>
        </div>
    </div>
</body>
</html>
