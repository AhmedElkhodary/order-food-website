
<?php include('partials/menu.php'); ?>


	<!-- Start main section -->
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Food</h1>
			<button class="btn"><a href="add-food.php">Add New</a></button>
		    <div class="div_message_success">
		    	<?php	
					if(isset($_SESSION['add-food'])){
						//print session Message
						echo $_SESSION['add-food'];
						//remove session Message
						unset($_SESSION['add-food']);
					}	
					if(isset($_SESSION['delete-food'])){
						//print session Message
						echo$_SESSION['delete-food'];
						//remove session Message
						unset($_SESSION['delete-food']);				
					}
					if(isset($_SESSION['update-food'])){
						//print session Message
						echo$_SESSION['update-food'];
						//remove session Message
						unset($_SESSION['update-food']);				
					}
				?>
		    </div>	

			<table class="main-table">
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Description</th>
					<th>Price</th>
					<th>ImageName</th>
					<th>Featured</th>
					<th>active</th>
					<th>Action</th>
				</tr>

				<tr>
					<?php
						// select all foods
						$stmt = $con->prepare("SELECT * FROM food ORDER BY id DESC");
						$stmt->execute();
						$foods = $stmt->fetchAll();

						//display data in table
						foreach ($foods as $food) {
							echo "<tr>";
								echo "<td>". $food['id'] ."</td>"; 
								echo "<td>". $food['title']."</td>";
								echo "<td>". $food['Description'] ."</td>";
								echo "<td>". $food['price'] ."</td>";
								echo "<td><img src=". SITEURL ."images/food/". ((!empty($food['image_name']))? $food['image_name'] : "default_food.png") ."></img></td>"; 													
								echo "<td>". (($food['featured'] == '0')? "No" : "Yes") ."</td>";
								echo "<td>". (($food['active']   == '0')? "No" : "Yes") ."</td>";
								echo "<td><button class='btn'><a href='update-food.php?id=".    $food['id']  ."'>Edit</a></button> 
										  <button class='btn'><a href='delete-food.php?id=".    $food['id']  ."&image_name=". $food['image_name'] ."'>Delete</a></button>					  
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
