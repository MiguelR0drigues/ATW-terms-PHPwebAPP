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
          <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["user_name"] ?? "demo"); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <button class="button open-button">open modal</button> 
    
                <div>
                <?php if(isAdmin($_SESSION["type"])){ 
            echo '<a href="test.php" class="btn btn-primary ml-3">ADMIN</a>';
      }
        ?>
        <dialog class="modal" id="modal">
        <div class=modal-header>
            <h1>Insert a term</h1>
        </div>
        <form class="form" method="dialog">
        <label>Title</label>
        <input type="text" id="title">
        <label>Description</label>
        <input type="text" id="description" placeholder="(Max 140 characters)" maxlength="140">
        <input type="hidden" id="user-id" name="userId" value="<?php echo $_SESSION["id"]?>">
        <div class="btn2-group">
            <button class="button" id="submitForm" type="submit">submit form</button>
            <button class="close button"><b>Close</b></button>
            </form>
            </dialog>
 
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

        
     