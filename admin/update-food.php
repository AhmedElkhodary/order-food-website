<?php include('partials/menu.php');?> 

<?php

	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
		$id = $_GET['id'];
		//quary to get activeted category 
		$stmt1 = $con->prepare("SELECT id, title FROM category WHERE active = 1");
		$stmt1->execute();
		$cats = $stmt1->fetchAll();

		$stmt = $con->prepare("SELECT * From food WHERE id = ?");
		$stmt->execute(array($id));

		//check if the food data is available
		$count = $stmt->rowCount();
		if($count == 1){
			$food = $stmt->fetch();	
		} 
		else{

			//redirect to Food-category page
			header("location:". SITEURL . "admin/manage-food.php");
		}
	}
	else{

		//redirect to manage-Food page
		header("location:". SITEURL . "admin/manage-food.php");	
	}
?>

<div class="main-content">
	<div class="wrapper">
		<h1>Update Food</h1>
		
		<div class="form">
			<form action="" method="POST" enctype="multipart/form-data">
				
				<!-- title input -->
				<label>Title*</label>
				<input type="text" class="text" name="title" value="<?php echo $food['title']?>" required><br><br>

				<!-- Description input -->
				<label>Description</label>
				<textarea  class="textarea" rows="4"  name="desc" ><?php echo $food['Description']?></textarea><br><br>

				<!-- Price input -->
				<label>Price</label>
				<input type="text" class="text" name="price" value="<?php echo $food['price']?>"><br><br>

				<!-- CategoryName Selection -->
				<label>CategoryName</label>
				<select name="cat_id">
					<?php
						//for in all options
		 				foreach ($cats as $cat) {
							//set option (value = categoryID  list = categoryName)  and select the category for this food
							?>
							<option 
								value=<?php echo $cat['id']?> 
								<?php if($cat['id'] == $food['category_id']){echo "selected";}?>>
								<?php echo $cat['title']?>		
							</option>
							<?php
						}
					?>
				</select><br><br>
				<option selected></option>

				<!-- Image input -->
				<label>Image</label>
				<input type="file"  name="image"><br><br>
				
				<!-- Featured Selection -->
				<label>Featured</label>
						<input  type="radio" class="radio" name="featured" value="0" <?php if($food['featured'] == '0'){echo "checked";}?>>No
						<input  type="radio" class="radio" name="featured" value="1" <?php if($food['featured'] == '1'){echo "checked";}?>>Yes<br><br>

				<!-- Active Selection -->
				<label>Active</label>
						<input  type="radio" class="radio" name="active" value="0" <?php if($food['active'] == '0'){echo "checked";}?>>No
						<input  type="radio" class="radio" name="active" value="1" <?php if($food['active'] == '1'){echo "checked";}?>>Yes<br><br>						

				<!--Hidden data-->
				<input type="hidden" name="id" value="<?php echo $food['id']?>">	
				<input type="hidden" name="old_image" value="<?php echo $food['image_name']?>">		
				<!-- submit button -->
				<input type="submit" class="btn-save" name="submit" value="Save">
			</form>
		</div>
		<div class="div_message">
			<?php
				//check if session['update-food'] is exist
				if(isset($_SESSION['update-food'])){
					
					//print message
					echo $_SESSION['update-food'];
					//remove session
					unset($_SESSION['update-food']);
				}			
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
			?>
		</div>
	</div>
</div>


<?php
	//if post request existed
	if(isset($_POST['submit'])){

		// define formerrors
		$formErrors = array();

		//get date from form
		$title 		  = $_POST['title'];
		$desc 		  = $_POST['desc'];
		$price        = $_POST['price'];
		$cat_id       = $_POST['cat_id'];
		$featured     = $_POST['featured'];
		$active       = $_POST['active'];
		$imageName = $_FILES['image']['name'];
		//hidden data
		$id           = $_POST['id'];
		$old_image    = $_POST['old_image'];
	
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

				$formErrors[] = " Image Extension is Not Allowed ";
	    	}
	    	//check if imageSize grater than 2MB
	    	if($imageSize > 2097152 ){

				$formErrors[] = " Maximum size image 2MB ";
	    	}
		}
		else{
			$img_name = $old_image;
		}

		
		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			
			//redirect to update-food page
			header("location:". SITEURL . "admin/update-food.php?id=".$food['id']);
	        die();			
		}
		// if no error add data to database
		else{

			/* save image */
			//check if imageName not empty
			if (!empty($imageName)) {

				//delete the previous image
				if(!empty($old_image)){
	        		unlink('../images/food/'. $old_image);			
				}
				
				//set random name to image 
				$img_name = rand(0,1000000) . "_" . $imageName;
				
				//move image from temp postion to food image postion
	            move_uploaded_file($imageTmp, "../images/food/" . $img_name );			
			}


            /* Update food Data */
			//quary to update food in database 		
			$stmt = $con->prepare("UPDATE food SET title=?, Description=?, price=?, image_name=?, category_id=?,featured=?, active=? WHERE id=?");
			$stmt->execute(array($title, $desc, $price, $img_name, $cat_id , $featured, $active, $id ));

			//check update data in database successfully
			if($stmt == true){

				//set update-food session
				$_SESSION['update-food'] = 'Successfully Updated';
				
				//redirect to manage-food page
				header("location:". SITEURL . "admin/manage-food.php");
			}
			else{
				//set update-food session
				$_SESSION['update-food'] = 'Failed Update';
				//redirect to manage-food page
				header("location:". SITEURL . "admin/update-food.php");
			}
		}
	}
?>



<?php include('partials/footer.php')?>