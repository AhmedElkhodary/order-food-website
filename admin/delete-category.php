
<?php
	//include constants
	include('../config/CONSTANTS.php'); 

	// get  category id and imageName
	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['image_name'])){

		$id         =  $_GET['id'];
		$image_name =  $_GET['image_name'];


		// if Image is existed for category delete physical image file
		if(!empty($image_name)){
			
			//image path
			$path = "../images/category/" . $image_name;
			//delete image
			$remove = unlink($path);

			//check if file removed successfully
			if($remove == false){

				//set session vavaible
				$_SESSION['delete-category'] = ' Failed Delete Image ';
			    // redirect to manage-category page
			     header("location:". SITEURL ."admin/manage-category.php");	
			}
		}

		/*delete food image if is existed*/
		// 1-select image_name for food from food table
		$stmt = $con->prepare("SELECT image_name FROM food WHERE category_id = ?");
		$stmt->execute(array($id));
		$row = $stmt->fetch();
		$img_name = $row['image_name'];

		// 2- check whether name_image is existed or not
		if(!empty($img_name)){
			
			//image path
			$path = "../images/food/" . $img_name;
			//delete image
			$remove = unlink($path);
			//check if file removed successfully
			if($remove == false){

				//set session vavaible
				$_SESSION['delete-category'] = ' Failed Delete Image ';
			    // redirect to manage-category page
			     header("location:". SITEURL ."admin/manage-category.php");	
			}

		}


		//delete category from database
		$stmt = $con->prepare("DELETE FROM category WHERE id =?");
		$stmt->execute(array($id));


		if ($stmt == TRUE){
			
		    //set session vavaible
		    $_SESSION['delete-category'] = 'Category Deleted Successfully';
		    // redirect to manage-category page
		    header("location:". SITEURL ."admin/manage-category.php");
		}
		else{
			
			//set session vavaible
			$_SESSION['delete-category'] = 'Failed Delete Category';
		    // redirect to manage-category page
		     header("location:". SITEURL ."admin/manage-category.php");			
		}
	}
	
	else{
		//redirect to manage-category if any wrong in url
		header("location:". SITEURL ."admin/manage-category.php");	

	}
	
?>
