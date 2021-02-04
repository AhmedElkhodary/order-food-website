<?php include('partials/menu.php')?>
<?php
	//quary to get activeted category 
	$stmt = $con->prepare("SELECT id, title FROM category WHERE active = 1");
	$stmt->execute();
	$cats = $stmt->fetchAll();
?>

<div class="main-content">
	<div class="wrapper">
		<h1>Add Food</h1>
		<div class="form">
			<form action="" method="POST" enctype="multipart/form-data">
				
				<!-- title input -->
				<label>Title*</label>
				<input type="text" class="text" name="title" placeholder="Enter Title" required><br><br>

				<!-- Description input -->
				<label>Description</label>
				<textarea  class="textarea" rows="4"  name="desc" placeholder="Enter Description"></textarea><br><br>

				<!-- Price input -->
				<label>Price</label>
				<input type="number" class="text" name="price" placeholder="Enter Title"><br><br>

				<!-- CategoryName Selection -->
				<label>CategoryName</label>
				<select name="cat_id">
					<?php
						//for in all options
		 				foreach ($cats as $cat) {
							//set option (value = categoryID  list = categoryName)  
							echo "<option value='". $cat['id'] ."'>". $cat['title']  ."</option>";	
						}
					?>
				</select><br><br>

				<!-- Image input -->
				<label>Image</label>
				<input type="file"  name="image"><br><br>

				<!-- Featured Selection -->
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
		<div class="div_message">
			<?php
				//check if session['add-food'] is exist
				if(isset($_SESSION['add-food'])){
					
					//print message
					echo $_SESSION['add-food'];
					//remove session
					unset($_SESSION['add-food']);
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

				$formErrors[] = " Image Extension is Not Allowed ";
	    	}
	    	//check if imageSize grater than 2MB
	    	if($imageSize > 2097152 ){

				$formErrors[] = " Maximum size image 2MB ";
	    	}
		}
		else{
			$img_name = "";
		}

		
		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			//redirect to add-food page
			header("location:". SITEURL . "admin/add-food.php");
	        die();			
		}
		// if no error add data to database
		else{

			/* save image */
			//check if $imageName not empty
			if ($img_name != "") {
				
				//set random name to image 
				$img_name = rand(0,1000000) . "_" . $img_name;
				
				//move image from temp postion to food image postion
	            move_uploaded_file($imageTmp, "../images/food/" . $img_name );			
			}


            /* Save New food Data */
			//quary to Add new food in database
			$stmt = $con->prepare("INSERT INTO food(title, Description, price, image_name, category_id,	featured, active)
										VALUES(:Ztitle, :ZDescription, :Zprice, :zimage_name, :Zcategory_id,:Zfeatured, :Zactive)");
			$stmt->execute(array(

				'Ztitle'       => $title,
				'ZDescription' => $desc,
				'Zprice'	   => $price,
				'zimage_name'  => $img_name,
				'Zcategory_id' => $cat_id,
				'Zfeatured'    => $featured,
				'Zactive'      => $active
			));

			//check add data in database successfully
			if($stmt == true){

				//set add-food session
				$_SESSION['add-food'] = 'Successfully Added';
				
				//redirect to manage-food page
				header("location:". SITEURL . "admin/manage-food.php");
			}
			else{
				//set add-food session
				$_SESSION['add-food'] = 'Failed Added';
				//redirect to add-food page
				header("location:". SITEURL . "admin/add-food.php");
			}
		}
	}
?>


<?php include('partials/footer.php')?>