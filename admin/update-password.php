<?php include('partials/menu.php');?>

<?php
	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
		
		$id = $_GET['id'];
		$stmt = $con->prepare("SELECT * From admin WHERE id = ?");
		$stmt->execute(array($id));

		//check if the admin data is available
		$count = $stmt->rowCount();
		if($count == 1){
			$admin = $stmt->fetch();	
		} 
		else{
			header("location:". SITEURL . "admin/manage-admin.php");
		}
	}
?>


<div class="main-content">
	<div class="wrapper">
		<h1>Update Password</h1>
		<div class="form">
			<form action="" method="POST">
				
				<!-- Current Password input -->
				<label>Current Password*</label>
				<input type="Password" class="text" name="current-password" placeholder="Enter current-password" required><br><br>

				<!-- New Password input -->
				<label> New Password*</label>
				<input type="Password" class="text" name="new-password" placeholder="Enter New-password" required><br><br>
				
				<!-- Confirm Password input -->
				<label> Confirm Password*</label>
				<input type="Password" class="text" name="confirm-password" placeholder="Confirm-password" required><br><br>

				<!--hidden input-->
				<input type="hidden" name="id" value="<?php echo $admin['id'];?>"/>;

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
				//check if session['errors'] is exist
				if(isset($_SESSION['update-pass'])){
					
					//print message
					echo $_SESSION['update-pass'];
					//remove session
					unset($_SESSION['update-pass']);
				}							
			?>
		</div>		
	</div>
</div>

<?php include('partials/footer.php')?>

<?php
	//check if change password is clicked
	if(isset($_POST['submit'])){
		
		// get data from form
		$current_pass = md5($_POST['current-password']);
		$new_pass     = md5($_POST['new-password']);
		$confirm_pass = md5($_POST['confirm-password']);
		//hidden input
		$id           = $_POST['id'];


		//check if currentPassword is empty
		if(empty($_POST['current-password'])){
			$formErrors[] = "CurrentPassword Empty";
		}
		//check if NewPassword is empty
		if(strlen($_POST['new-password']) < 4){
			$formErrors[] = "NewPassword is short";
		}
		//check if ConfirmPassword is empty
		if(strlen($_POST['confirm-password']) < 4){
			$formErrors[] = "ConfirmPassword is short";
		}
		// check whether current-password is not equal new-password or not
		if($current_pass === $new_pass){
			$formErrors[] = "Current-Password and New-password Should not matched!";	
		}
		//check whether the new-password equal confirm-password or not
		if ($new_pass !== $confirm_pass){
			$formErrors[] = "Password Not match!";
		}

		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			//redirect to update-category page
			header("location:". SITEURL . "admin/update-password.php?id=" . $id);
	        die();			
		}
		// if no error go to database
		else{

			//check whether current-password is true or not
			$stmt = $con->prepare("SELECT password FROM admin WHERE id = ?");
			$stmt->execute(array($id));
			$pass = $stmt->fetch()[0];

			//check Whether current-password from form is equal password from database or not
			if($current_pass === $pass){
					
				// update password
				$stmt = $con->prepare("UPDATE admin SET password=?  WHERE id = ?");
				$stmt->execute(array($new_pass, $id));
								
				//set update-pass session
				$_SESSION['update-pass'] = 'Successfully Updated Password';
				//redirect to manage-admin page
				header("location:". SITEURL . "admin/manage-admin.php");		
			}
			else{

				//set update-pass session
				$_SESSION['update-pass'] = 'CurrentPassword is False';
				//redirect to update-password page
				header("location:". SITEURL . "admin/update-password.php?id=" . $id);
				die();
			}
		}	
	}
?>



