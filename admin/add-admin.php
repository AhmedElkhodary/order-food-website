<?php include('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Add Admin</h1>
		<div class="form">
			<form action="" method="POST" enctype="multipart/form-data">
				
				<!-- UserName input -->
				<label>UserName*</label>
				<input type="text" class="text" name="user_name" placeholder="Enter UserName"><br><br>

				<!-- Password input -->
				<label>Password*</label>
				<input type="password" class="text"  placeholder="Enter password" name="password"></td><br><br>

				<!-- FullName input -->
				<label>FullName*</label>
				<input type="text" class="text" name="full_name" placeholder="Enter FullName"><br><br>
						
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
				//check if session['add-admin'] is exist
				if(isset($_SESSION['add-admin'])){
					//print session Message
					echo $_SESSION['add-admin'];
					//remove session Message
					unset($_SESSION['add-admin']);
				}				
			?>
		</div>
	</div>
</div>


<?php include('partials/footer.php')?>


<?php
	//check if save button is clicked
	if(isset($_POST['submit'])){

		//Get Data from From
		$user_name = $_POST['user_name'];
		$password  = md5($_POST['password']);
		$full_name = $_POST['full_name'];

		//check if UserName is empty
		if(empty($user_name)){
			$formErrors[] = "UserName Empty";
		}
		//check if Password is empty
		if(empty($_POST['password'])){
			$formErrors[] = "Password Empty";
		}
		//check if FullName is empty
		if(empty($full_name)){
			$formErrors[] = "FullName Empty";
		}

		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			//redirect to add-category page
			header("location:". SITEURL . "admin/add-admin.php");
	        die();			
		}		

		// if no error add data to database
		else{

            /* Save New admin Data */
			//quary to Add new admin in database
			$stmt = $con->prepare("INSERT INTO admin(user_name, full_name, password )
								   VALUES(:zuser_name, :zfull_name, :zpassword)");
			$stmt->execute(array( 
				'zuser_name' => $user_name,
				'zfull_name' => $full_name,
				'zpassword'  => $password,
			));

			//check add data in database successfully
			if($stmt == true){

				//set add-admin session
				$_SESSION['add-admin'] = 'Successfully Added';
				//redirect to manage-admin page
				header("location:". SITEURL . "admin/manage-admin.php");
			}
			else{
				//set add-admin session
				$_SESSION['add-admin'] = 'Failed Added';
				//redirect to add-admin page
				header("location:". SITEURL . "admin/add-admin.php");
			}
		}
	}
?>
