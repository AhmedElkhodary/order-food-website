<?php include('partials/menu.php'); ?>

<?php

	if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
		
		$id = $_GET['id'];


		$stmt = $con->prepare("SELECT * From t_order WHERE id = ?");
		$stmt->execute(array($id));

		//check if the order data is available
		$count = $stmt->rowCount();
		if($count == 1){
			$order = $stmt->fetch();	
		} 
		else{

			//redirect to manage-order page
			header("location:". SITEURL . "admin/manage-order.php");
		}
	}
	else{

		//redirect to manage-order page
		header("location:". SITEURL . "admin/manage-order.php");	
	}
?>


<div class="main-content">
	<div class="wrapper">
		<h1>Update Order</h1>
		
		<div class="form">
			<form action="" method="POST">
				
				<!-- Food name input -->
				<label>FoodName</label>
				<label><?php echo $order['food']?></label><br><br>
				
				<!-- Quantity input -->
				<label>Quantity</label>
				<input type="number" class="text" name="qty" value="<?php echo $order['qty']?>"><br><br>



				<!-- Status input -->
				<label>Status</label>
				<select class="" name="status">
					<option value="Ordered"    <?php  if($order['status'] == 'Ordered')   {echo "selected";}?>>Ordered</option>
					<option value="OnDelivery" <?php  if($order['status'] == 'OnDelivery'){echo "selected";}?>>OnDelivery</option>
					<option value="Delivered"   <?php  if($order['status'] == 'Delivery')  {echo "selected";}?>>Delivered</option>
					<option value="Cancelled"  <?php  if($order['status'] == 'Cancelled') {echo "selected";}?>>Cancelled</option>
				</select><br><br>

					

				<!--Hidden data-->
				<input type="hidden" name="id" value="<?php echo $order['id']?>">	
	
				<!-- submit button -->
				<input type="submit" class="btn-save" name="submit" value="Save">
			</form>
		</div>
		<div class="div_message">
			<?php
				//check if session['update-order'] is exist
				if(isset($_SESSION['update-order'])){
					
					//print message
					echo $_SESSION['update-order'];
					//remove session
					unset($_SESSION['update-order']);
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
		$qty 		  = $_POST['qty'];
		$status       = $_POST['status'];
	
		//hidden data
		$id           = $_POST['id'];

		
		//check if any error is existed redirect and print error 
		if(!empty($formErrors)){
			
			//set errors session
			$_SESSION['errors'] = $formErrors;
			
			//redirect to update-order page
			header("location:". SITEURL . "admin/update-order.php?id=".$order['id']);
	        die();			
		}
		// if no error add data to database
		else{



            /* Update Order Data */
			//quary to update order in database 		
			$stmt = $con->prepare("UPDATE t_order SET qty=?,status=? WHERE id=?");
			$stmt->execute(array($qty, $status, $id ));

			//check update data in database successfully
			if($stmt == true){

				//set update-order session
				$_SESSION['update-order'] = 'Successfully Updated';
				
				//redirect to manage-order page
				header("location:". SITEURL . "admin/manage-order.php");
			}
			else{
				//set update-order session
				$_SESSION['update-order'] = 'Failed Update';
				//redirect to manage-order page
				header("location:". SITEURL . "admin/update-prder.php");
			}
		}
	}
?>

<?php include('partials/footer.php')?>