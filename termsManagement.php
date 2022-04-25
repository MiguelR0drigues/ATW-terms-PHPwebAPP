<?php
session_start();
include 'db.connection.php';
include "functions.php";
// checking session is valid for not 
isAccountReady();
  // for deleting user 
if(isset($_GET['id'])) 
{ 
$id=$_GET['id']; 
$msg=mysqli_query($link,"delete from termos where id='$id'"); 
if($msg) 
{ 
} 
} 
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Admin | Manage Users</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="fonts/font-awesome.css" rel="stylesheet" />
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
                          <span>Reset Password</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="userManagement.php" >
                          <i class="fa fa-users"></i>
                          <span>Gerir Users</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="addUser.php" >
                          <i class="fa fa-users"></i>
                          <span>Adicionar User</span>
                      </a>
                </li>
                <li class="sub-menu">
                      <a href="index.php" >
                          <i class="fa fa-users"></i>
                          <span>Voltar Pagina Inicial</span>
                      </a>
                </li>
              </ul>
          </div>
      </aside>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Manage Users</h3>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> All User Details </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Title</th>
                                  <th>Description </th>
                                  <th>Owner</th>
                                  <th>Date</th> 
                                  <th>Revised? </th>
                                  <th>Aprove</th>
                                  <th>Disapprove</th>
                                  <th>Delete</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $ret=mysqli_query($link,"select * from termos");
							
							  while($row=mysqli_fetch_array($ret))
							  {?>
                              <tr>
                                  <td><?php echo $row['id'];?></td>
                                  <td><?php echo $row['title'];?></td>
                                  <td><?php echo $row['description'];?></td>
                                  <td><?php echo ownerNameByID($row['owner'],$link)?></td>
                                  <td><?php echo $row['pubDate'];?></td>
                                  <td><?php if($row['revisto']==0){ ?> <i class="fa fa-times"> <?php } else { ?> <i class="fa fa-check"> <?php } ?>
                                  <td>        
                                     <a href="aproveTerm.php?id=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-check"></i></button></a>
                                  </td>
                                  <td>        
                                     <a href="disapproveTerm.php?id=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-times"></i></button></a>
                                  </td>
                                  <td>
                                  <a href="termsManagement.php?id=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');"><i class="fa fa-trash-o "></i></button></a>
                                  </td>
                              </tr>
                              <?php }?>
                             
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
		</section>
      </section
  ></section>
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