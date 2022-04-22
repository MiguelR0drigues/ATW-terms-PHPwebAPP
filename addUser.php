<?php
session_start();
include'db.connection.php';
require "functions.php";
//Checking session is valid or not
isAccountReady();

$password_err="";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome=$_POST['nome'];
    $email=$_POST['email'];
    $tipo=$_POST['tipo'];
    $palavrapasse=$_POST['palavrapasse'];
    $estado=$_POST['estado'];
    $validado=$_POST['validado'];
    $_SESSION['msg']="Profile added successfully";
    // Prepare an insert statement
    $sql = "INSERT INTO users (nome, email, palavrapasse,tipo,estado,validado) VALUES (?,?,?,?,?,?)";
    
         // Validate password
         if (empty(trim($_POST["palavrapasse"]))) {
            $password_err = "Please enter a password.";
                } elseif (strlen(trim($_POST["palavrapasse"])) < 6) {
            $password_err = "Password must have atleast 6 characters.";
                } else {
            $palavrapasse = trim($_POST["palavrapasse"]);
        }
    

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, 'sssiii', $param_name, $param_email, $param_password, $param_tipo, $param_estado, $param_validado);

        // Set parameters
        $param_email = $email;
        $param_password = password_hash($palavrapasse, PASSWORD_DEFAULT);; // Creates a password hash
        $param_name = $nome;
        $param_estado = $estado;
        $param_tipo = $tipo;
        $param_validado = $validado;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            header("location: userManagement.php");
        } else {
            echo "QUERY:::::Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }


    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Update Profile</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

  <section id="container" >
      <header class="header black-bg">
            <a href="userManagement.php" class="logo"><b>Admin Dashboard</b></a>
            <div class="nav notify-row" id="top_menu">
               
                         
                   
                </ul>
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              <h5 class="centered"> Admin </h5>
                  <li class="mt">
                      <a href="reset-password.php">
                          <i class="fa fa-users"></i>
                          <span>Change Password</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="userManagement.php" >
                          <i class="fa fa-users"></i>
                          <span>Manage Users</span>
                      </a>
                   
                  </li>
              </ul>
          </div>
      </aside>

      <section id="main-content">
          <section class="wrapper">
				<div class="row">
                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'] ?? "";?></p>
                           <form class="form-horizontal style-form" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Nome </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="nome"  >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Email</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="email"  >
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Palavra-Passe</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="palavrapasse"  >
                                  <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>
                          </div>
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Tipo </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="tipo" >
                              </div>
                          </div>
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">estado</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="estado" >
                              </div>
                          </div>
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">validado</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="validado" >
                              </div>
                          </div>
                          <div style="margin-left:100px;">
                          <input type="submit" name="Submit" value="Submit" class="btn btn-theme"></div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
        <?php  ?>
      </section></section>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
  <script>
      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
<?php  ?>