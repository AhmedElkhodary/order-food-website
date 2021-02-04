<?php include('partials/menu.php'); ?>

<?php
	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
		$id = $_GET['id'];
		$stmt = $con->prepare("SELECT * From category WHERE id = ?");
		$stmt->execute(array($id));

		//check if the category data is available
		$count = $stmt->rowCount();
		if($count == 1){
			$cat = $stmt->fetch();	
		} 
		else{

			//redirect to manage-category page
			header("location:". SITEURL . "admin/manage-category.php");
		}
	}
	else{

		//redirect to manage-category page
		header("location:". SITEURL . "admin/manage-category.php");	
	}
?>


<div class="main-content">
	<div class="wrapper">
		<h1>Update Category</h1>
		<div class="form">
			<form action="" method="POST" enctype="multipart/form-data">
				
				<!-- title input -->
				<label>Title*</label>
				<input type="text" class="text" name="title" value="<?php echo $cat['title']?>" placeholder="Enter Title" required ><br><br>

				<!-- Image input -->
				<label>Image</label>
				<input type="file" name="image"></td><br><br>

				<!-- Featured input -->
				<label>Featured</label>
				<input  type="radio" name="featured" value="0" <?php if($cat['featured'] == '0'){echo "checked";}?>><span>NO</span>
				<input  type="radio" name="featured" value="1" <?php if($cat['featured'] == '1'){echo "checked";}?>><span>Yes</span><br><br>

				<!-- Active Selection -->
				<label>Active</label>
						<input  type="radio" name="active" value="0" <?php if($cat['active'] == '0'){echo "checked";}?>><span>NO</span>
						<input  type="radio" name="active" value="1" <?php if($cat['active'] == '1'){echo "checked";}?>><span>Yes</span><br><br>							
				
				<!-- hidden input -->
				<input type="hidden" name="id" value="<?php echo $cat['id']?>">
				<input type="hidden" name="old_image" value="<?php echo $cat['image_name']?>">
				
				<!-- submit button -->
				<input type="submit" class="btn-save" name="submit" value="Save">
			</form>
		</div>

		<!--Div to show message error-->
 		<div class="div_message">
			<?php
				//check if session['errors'] is exist
				if(isset($_SESSION['errors'])){
					
					//print message
					$errors = $_SESSION['errors'];
					foreach ($errors as $error) {
						echo $error."<br>";
					}
					//remove session
					unset($_SESSION['errors']);
				}
				//check if session['update-category'] is exist
				if(isset($_SESSION['update-category'])){
					//print session Message
					echo $_SESSION['update-category'];
					//remove session Message
					unset($_SESSION['update-category']);
				}				
			?>
		</div>
	</div>
</div>

<?php include('partials/footer.php')?>

<?php
	//check if button is clicked
	if(isset($_POST['submit'])){

		//Get Data from From
		$title     = $_POST['title'];
		$featured  = $_POST['featured'];
		$active    = $_POST['active'];
		$imageName = $_FILES['image']['name'];
		//hidden input
		$id        = $_POST['id'];
		$old_image = $_POST['old_image'];
		
		//check if title is empty
		if(empty($title)){
			$formErrors[] = "Title Empty";
		}

		//image process
		if(isset($imageName) && !empty($imageName)){

	    	//Upload Variables
	    	$imageName = $_FILES['image']['name'];
	    	$imageSize = $_FILES['image']['size'];
	    	$imageTmp  = $_FILES['image']['tmp_name'];
	    	$imageType = $_FILES['image']['type'];

	    	//List of Allowed File Typed
	    	$AllowedExtension = array( "jpeg", "jpg", "png", "gif");

	    	//explode image name to get the extension
	   		$name_exp = explode('.', $imageName); 
	   		$imageExtension = strtolower(end($name_exp));
    
	   		//check if image extensionextention is not in AllowedExtensions
			if(!in_array($imageExtension, $AllowedExtension)){

				//error in extension
				$formErrors[] = " Image Extension is Not Allowed ";
	    	}
	    	//check if imageSize grater than 2MB
	    	if($imageSize > 2097152 ){
	    		
	    		//error in size
				$formErrors[] = " Maximum size image 2MB ";
	    	}
		}
		else{

			//no new image
			$img_name = $old_image;
		}
		
		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			
			//redirect to update-food page
			header("location:". SITEURL . "admin/update-category.php?id=".$cat['id']);
	        die();			
		}

		// if no error add data to database
		else{

			/* save image */
			//check if imageName not empty
			if (!empty($imageName)) {

				//delete the previous image
				if(!empty($old_image)){
	        		unlink('../images/category/'. $old_image);			
				}
				
				//set random name to image 
				$img_name = rand(0,1000000) . "_" . $imageName;
				
				//move image from temp postion to category image postion
	            move_uploaded_file($imageTmp, "../images/category/" . $img_name );			
			}


            /* Update category Data */
			//quary to update category in database 		
			$stmt = $con->prepare("UPDATE category SET title=?, image_name=?, featured=?, active=? WHERE id=?");
			$stmt->execute(array($title, $img_name, $featured, $active, $id ));

			//check update data in database successfully
			if($stmt == true){

				//set update-category session
				$_SESSION['update-category'] = 'Successfully Updated';
				
				//redirect to manage-category page
				header("location:". SITEURL . "admin/manage-category.php");
			}
			else{
				//set update-category session
				$_SESSION['update-category'] = 'Failed Update';
				//redirect to manage-category page
				header("location:". SITEURL . "admin/update-category.php");
			}
		}
	}
?>


		

