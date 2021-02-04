<?php include('../config/CONSTANTS.php'); ?>
<?php

	// get the  admin id
	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){

		$id  =  $_GET['id'];
		
		//delete admin from database
		$stmt = $con->prepare("DELETE FROM admin WHERE id =?");
		$stmt->execute(array($id));


		if ($stmt == TRUE){
			
		    //set session vavaible
		    $_SESSION['delete-admin'] = 'Admin Deleted Successfully';
		    // redirect to manage-admin page
		    header("location:". SITEURL ."admin/manage-admin.php");
		}
		else{
			
			//set session vavaible
			$_SESSION['delete-admin'] = 'Failed Delete Category';
		    // redirect to add-admin page
		    header("location:". SITEURL ."admin/manage-admin.php");			
		}
	}
	else{
	//redirect to manage-admin if any wrong in url
	header("location:". SITEURL ."admin/manage-admin.php");	

	}
?>
