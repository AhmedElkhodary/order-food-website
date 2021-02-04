
<?php include('partials/menu.php'); ?>

	<!-- Start main section -->
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Order</h1>
		    <div class="div_message_success">
		    	<?php	
					if(isset($_SESSION['update-order'])){
						//print session Message
						echo$_SESSION['update-order'];
						//remove session Message
						unset($_SESSION['update-order']);				
					}
				?>
		    </div>				

			<table class="main-table">
				<tr>
					<th>Id</th>
					<th>Food</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
					<th>Date</th>
					<th>CustomerName</th>
					<th>CustomerContact</th>
					<th>CustomerEmail</th>
					<th>CustomerAddress</th>
					<th>Status</th>
					<th>Action</th>
				</tr>

				<tr>
					<?php
						// select all foods
						$stmt = $con->prepare("SELECT * FROM t_order ORDER BY id DESC");
						$stmt->execute();
						$orders = $stmt->fetchAll();

						//display data in table
						foreach ($orders as $order) {
							echo "<tr>";
								echo "<td>". $order['id'] ."</td>"; 
								echo "<td>". $order['food'] ."</td>"; 
								echo "<td>". $order['price'] ."</td>"; 		
								echo "<td>". $order['qty'] ."</td>"; 
								echo "<td>". $order['total'] ."</td>"; 
								echo "<td>". $order['order_date'] ."</td>"; 		
								echo "<td>". $order['customer_name'] ."</td>"; 
								echo "<td>". $order['customer_contact'] ."</td>"; 
								echo "<td>". $order['customer_email'] ."</td>";
								echo "<td>". $order['customer_address'] ."</td>";
								echo "<td>". $order['status'] ."</td>";
								echo "<td><button class='btn'><a href='". SITEURL . "admin/update-order.php?id=" . $order['id'] ."'>Update</a></button> 

									 </td>";								 																								
							echo "</tr>";
						}
					?>
				</tr>
			</table>			
			



			<dir class="clearfix"></dir>
		</div>			
	</div>
	<!-- end   main section -->

<?php include('partials/footer.php')?>
