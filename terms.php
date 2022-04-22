<?php
include("termsInfo.php");
include("functions.php");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<button class="open-button btn btn-dark">Insert Term</button>

<div class="container">
 <div class="row">
   <div class="col-sm-8">
    <?php echo $deleteMsg??''; ?>
  <?php
      if(is_array($fetchData)){      
      foreach($fetchData as $data){
    ?>
    <div class="card" style="width: 30rem;">
        <div class="card-header"  style="display: flex; justify-content: space-between;">
            <a href="term.php?id=<?php echo $data["id"] ?>"><?php echo $data['title']??''; ?></a>
            <p style="text-align: end;"><?php echo (ownerNameByID($data['owner'],$link))??'Unknown'; ?></p>
        </div> 
        <div class="card-body">
            <p class="card-text"><?php echo $data['description']??''; ?></p>
        <div style="display: flex; justify-content: space-between; margin-top:3rem">
            <h6 class="" style="text-align: end; font-size:small;color:grey;"><?php echo $data['pubDate']??''; ?></h6>
            <?php
            if(isAdmin($_SESSION["type"])){
              echo '<div>';
              echo '<a href="editTerm.php?id=',$data["id"],'" class="card-link" style="font-size:small;">Edit</a>';
              echo '<a href="deleteTerm.php?id=',$data["id"],'" class="card-link" style="font-size:small;">Delete</a>';
              echo '</div>'; 
            }
            ?>
        </div>
        </div>
    </div> <br>
     <?php }}else{ ?>
    <?php echo $fetchData; ?>
    <?php
    }?>
   </div> <?php       
   if(isset($_GET["term_err"]) && $_GET["term_err"]==1){
                echo '<div class="alert alert-warning" role="alert" style="width:25%;margin:auto;">';
                echo 'This term already exists.';
                echo '</div>';
            }?>
        <dialog class="Termsmodal" id="Termsmodal">
            <div class=Termsmodal-header>
                <h1>Insert a term</h1>
            </div>
            <form class="form" method="dialog">
                <label>Title</label>
                <input type="text" id="title" maxlength="100">
                <label>Description</label>
                <input type="text" id="description" placeholder="(Max 140 characters)" maxlength="140">
                <input type="hidden" id="user-id" name="userId" value="<?php echo $_SESSION["id"]?>">
                <div class="btn2-group">
                    <button class="button" id="submitForm" type="submit">submit form</button>
                    <button class="close button"><b>Close</b></button>
                </div>
            </form>
        </dialog>
</div>
</div>
</div>
<script src="js/modal.js"></script> 
</body>
</html>