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
		<h1>Update Admin</h1>
		<div class="form">
			<form action="" method="POST" enctype="multipart/form-data">
				
				<!-- UserName input -->
				<label>UserName*</label>
				<input type="text" class="text" name="user_name" required value="<?php echo $admin['user_name'];?>"><br><br>

				<!-- FullName input -->
				<label>FullName*</label>
				<input type="text" class="text" name="full_name" required value="<?php echo $admin['full_name']; ?>"><br><br>
						
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
				//check if session['update-admin'] is exist
				if(isset($_SESSION['update-admin'])){
					//print session Message
					echo $_SESSION['update-admin'];
					//remove session Message
					unset($_SESSION['update-admin']);
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
		$user_name = $_POST['user_name'];
		$full_name = $_POST['full_name'];
		//hidden input
		$id        = $_POST['id'];
		

		//check if UserName is empty
		if(empty($user_name)){
			$formErrors[] = "UserName Empty";
		}
		//check if FullName is empty
		if(empty($full_name)){
			$formErrors[] = "FullName Empty";
		}

		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			//redirect to update-category page
			header("location:". SITEURL . "admin/update-admin.php?id=" . $id);
	        die();			
		}

		// if no error add data to database
		else{

            /* Update admin Data */
			//quary to update admin in database 		
			$stmt = $con->prepare("UPDATE admin SET user_name= ?, full_name= ? WHERE id= ? ");
			$stmt->execute(array($user_name, $full_name, $id));

			//check update data in database successfully
			if($stmt == true){

				//set update-admin session
				$_SESSION['update-admin'] = 'Successfully Updated';
				
				//redirect to manage-admin page
				header("location:". SITEURL . "admin/manage-admin.php");
			}
			else{
				//set update-admin session
				$_SESSION['update-admin'] = 'Failed Update';
				//redirect to manage-admin page
				header("location:". SITEURL . "admin/update-admin.php");
			}
		}
	}
?>
