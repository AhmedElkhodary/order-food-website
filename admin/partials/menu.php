
<?php include('../config/CONSTANTS.php'); ?>

<?php
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>



<!DOCTYPE html>
<html>
<head>
	<title>food oreder website</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
	<!-- Start menu section -->
	<div class="menu">
		<div class="wrapper">
			<ul>
				<li><a href="index.php">           Home</a></li>
				<li><a href="manage-admin.php">    Admin</a></li>
				<li><a href="manage-category.php"> Category</a></li>
				<li><a href="manage-food.php">     Food</a></li>
				<li><a href="manage-order.php">    Order</a></li>
				<li><a href="logout.php">          Logout</a></li>				
			</ul>	
		</div>
	</div>
	<!-- end   menu section -->