<?php
// Initialize the session
session_start();

require 'functions.php';
isAccountReady();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Welcome</title>
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">
     <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/index.css">
     <link rel="stylesheet" href="css/modal.scss">

</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">
               <span class="spinner-rotate"></span>
          </div>
     </section>


     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="#" class="navbar-brand">Blog Website</a>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li class="active"><a href="index.php">Home</a></li>
                         <li><a href="test.php">Termos</a></li>
                         <li><a href="about-us.html"></a></li>
                         <li><a href="team.html"></a></li>
                         <li><a href="contact.html"></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Sign Out of Your Account</a></li>
                    <li><a href="reset-password.php">Reset Your Password</a></li>
                    </ul>
          </div>
     </section>
     <main>
          <section>
               <div class="container">
                    <div class="row">
                         <div class="col-md-12 col-sm-12">
                              <div class="text-center">
                                   <h2>About us</h2>
                                   <br>
                                   <p class="lead">We are 2 students from ISPGAYA doing a project for ATW.</p>
                              </div>
                         </div>
                    </div>
               </div>
          </section>
          <?php
    if(isset($_GET["term_err"]) && $_GET["term_err"]==1){
        echo '<div class="alert alert-warning" role="alert">';
        echo 'This term already exists.';
        echo '</div>';
    }

    ?>
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
     </div>
     </main>
         <!-- SCRIPTS -->
         <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>
     <script src="js/modal.js"></script> 
</body>
</html>

        
     