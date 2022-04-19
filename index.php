<?php
// Initialize the session
session_start();

require 'functions.php';
include("terms.php");
isAccountReady();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="modal.scss">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body><?php
    if(isset($_GET["term_err"]) && $_GET["term_err"]==1){
        echo '<div class="alert alert-warning" role="alert">';
        echo 'This term already exists.';
        echo '</div>';
    }

    ?>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["user_name"] ?? "demo"); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <button class="open-button btn btn-dark">open modal</button>
        <?php if(isAdmin($_SESSION["type"])){
            echo '<a href="test.php" class="btn btn-primary ml-3">ADMIN</a>';
        }
        ?>

        <div>
        <?php echo $deleteMsg??''; ?>
        <?php
            if(is_array($fetchData)){      
            $sn=1;
            foreach($fetchData as $data){
            ?>
            <div class="card" style="width: 30rem;">
                <div class="card-header"  style="display: flex; justify-content: space-between;">
                    <p><a href="term.php?id=<?php echo $data['id']??''; ?>" > <?php echo $data['title']??''; ?></a></p>
                    <p style="text-align: end;"><?php echo (ownerNameByID($data['owner'],$link))??'Unknown'; ?></p>
                </div> 
                <div class="card-body">
                    <p class="card-text"><?php echo $data['description']??''; ?></p>
                <div style="display: flex; justify-content: space-between; margin-top:3rem">
                    <h6 class="" style="text-align: end; font-size:small;color:grey;"><?php echo $data['pubDate']??''; ?></h6>
                    <?php
                    if(isAdmin($_SESSION["type"])|| isOwner($_SESSION["id"], $data["id"],$link)){
                        echo '<div>';
                        echo '<a href="#" class="card-link" style="font-size:small;">Edit</a>';
                        echo '<a href="deleteTerm.php?id=',$data["id"],'" class="card-link" style="font-size:small;">Delete</a>';
                        echo '</div>';   
                    }
                    ?>
                </div>
                </div>
            </div><br>
            <?php
            $sn++;}}else{ ?>
            <?php echo $fetchData; ?>
            <?php
            }?>
        </div>

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
    </p>
</body>
<script src="modal.js"></script>
</html>