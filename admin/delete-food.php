
<?php
	//include constants
	include('../config/CONSTANTS.php'); 

	// get  category id and imageName
	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['image_name'])){

		$id         =  $_GET['id'];
		$image_name =  $_GET['image_name'];


		// if Image is existed for food delete physical image file
		if(!empty($image_name)){
			
			//image path
			$path = "../images/food/" . $image_name;
			
			//delete image
			$remove = unlink($path);

			//check if file removed successfully
			if($remove == false){

				//set session vavaible
				$_SESSION['delete-food'] = 'Failed Delete Image' ;
			    // redirect to manage-food page
			     header("location:". SITEURL ."admin/manage-food.php");	
			}
		}



		//delete food from database
		$stmt = $con->prepare("DELETE FROM food WHERE id =?");
		$stmt->execute(array($id));


		if ($stmt == TRUE){
			
		    //set session vavaible
		    $_SESSION['delete-food'] = 'Successfully Deleted';
		    // redirect to manage-food page
		    header("location:". SITEURL ."admin/manage-food.php");
		}
		else{
			
			//set session vavaible
			$_SESSION['delete-food'] = 'Faild Delete';
		    // redirect to manage-food page
		     header("location:". SITEURL ."admin/manage-food.php");			
		}
	}
	
	else{
		//redirect to manage-food if any wrong in url
		header("location:". SITEURL ."admin/manage-food.php");	

	}
	
?>
