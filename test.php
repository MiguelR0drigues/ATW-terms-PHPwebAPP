<?php
include("terms.php");
include("functions.php");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
 <div class="row">
   <div class="col-sm-8">
    <?php echo $deleteMsg??''; ?>
  <?php
      if(is_array($fetchData)){      
      $sn=1;
      foreach($fetchData as $data){
    ?>
    <div class="card" style="width: 30rem;">
        <div class="card-header"  style="display: flex; justify-content: space-between;">
            <p><?php echo $data['title']??''; ?> <!--LOREM IPSUM--></p>
            <p style="text-align: end;"><?php echo (ownerNameByID($data['owner'],$link))??'Unknown'; ?></p>
        </div> 
        <div class="card-body">
            <p class="card-text"><?php echo $data['description']??''; ?><!--Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et ma--></p>
        <div style="display: flex; justify-content: space-between; margin-top:3rem">
            <h6 class="" style="text-align: end; font-size:small;color:grey;"><?php echo $data['pubDate']??''; ?></h6>
            <?php
            if(isAdmin($_SESSION["type"])){
                echo '<div>';
                echo '<a href="#" class="card-link" style="font-size:small;">Edit</a>';
                echo '<a href="#" class="card-link" style="font-size:small;">Delete</a>';
                echo '</div>';
            }
            ?>
        </div>
        </div>
    </div> <br>
     <?php
      $sn++;}}else{ ?>
    <?php echo $fetchData; ?>
    <?php
    }?>
   </div>
</div>
</div>
</div>
</body>
</html>