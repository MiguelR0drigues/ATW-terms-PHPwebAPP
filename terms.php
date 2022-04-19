<?php
include("db.connection.php");
require 'functions.php';
$db= $link;
$tableName="termos";
$columns= ['id', 'title','description','owner','pubDate', 'revDate','altDate'];
$fetchData = fetch_data($db, $tableName, $columns);

?>