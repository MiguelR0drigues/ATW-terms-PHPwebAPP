<?php
session_start();
include'db.connection.php';
require "functions.php";
//Checking session is valid or not
isAccountReady();

$nome=$_REQUEST['nome'];
	$email=$_REQUEST['email'];
	$tipo=$_REQUEST['tipo'];
    $palavrapasse=$_REQUEST['palavrapasse'];
    $estado=$_REQUEST['estado'];
    $validado=$_REQUEST['validado'];
$query=mysqli_query($link,"INSERT INTO users Values( NULL,'$nome' ,'$email' ,'$palavrapasse','$tipo','$estado', '$validado'");
$_SESSION['msg']="Profile added successfully";
?>