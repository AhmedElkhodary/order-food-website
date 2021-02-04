<?php include('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Add Category</h1>
		<div class="form">
			<form action="" method="POST" enctype="multipart/form-data">
				
				<!-- title input -->
				<label>Title*</label>
				<input type="text" class="text" name="title" placeholder="Enter Title" required ><br><br>

				<!-- Image input -->
				<label>Image</label>
				<input type="file" name="image"></td><br><br>

				<!-- Featured input -->
				<label>Featured</label>
				<input type="radio" class="radio" name="featured" value="0" checked >No
				<input type="radio" class="radio" name="featured" value="1">Yes<br><br>

				<!-- Active Selection -->
				<label>Active</label>
				<input type="radio" class="radio" name="active" value="0" checked >No
				<input type="radio" class="radio" name="active" value="1">Yes<br><br>							
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
		$imageName    = $_FILES['image']['name'];

		//check if title is empty
		if(empty($title)){
			$formErrors[] = "Title Empty";
		}

		//image process
		if(isset($imageName) && !empty($imageName)){
		
	    	//Upload Variables
	    	$img_name = $_FILES['image']['name'];
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

			//no image
			$img_name = "";
		}
		
		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			//redirect to add-category page
			header("location:". SITEURL . "admin/add-category.php");
	        die();			
		}
		// if no error add data to database
		else{

			/* save image */
			//check if $imageName not empty
			if ($img_name != "") {
				
				//set random name to image 
				$img_name = rand(0,1000000) . "_" . $img_name;
				
				//move image from temp postion to category image postion
	            move_uploaded_file($imageTmp, "../images/category/" . $img_name );			
			}


            /* Save New category Data */
			//quary to Add new category in database
			$stmt = $con->prepare("INSERT INTO category(title, image_name, featured, active )
								   VALUES(:ztitle, :zimage_name, :zfeatured, :zactive)");
			$stmt->execute(array( 
				'ztitle'      => $title,
				'zimage_name' => $img_name,
				'zfeatured'   => $featured,
				'zactive'     => $active,
			));

			//check add data in database successfully
			if($stmt == true){

				//set add-category session
				$_SESSION['add-category'] = 'Successfully Added';
				//redirect to manage-category page
				header("location:". SITEURL . "admin/manage-category.php");
			}
			else{
				//set add-category session
				$_SESSION['add-category'] = 'Failed Added';
				//redirect to add-category page
				header("location:". SITEURL . "admin/add-category.php");
			}
		}
	}
?>



