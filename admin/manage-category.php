
<?php include('partials/menu.php'); ?>

	<!-- Start main section -->
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Category</h1>
			<button class="btn"><a href="add-category.php">Add New</a></button>
			<div class="div_message_success">
				<?php	
					if(isset($_SESSION['add-category'])){
						//print session Message
						echo $_SESSION['add-category'];
						//remove session Message
						unset($_SESSION['add-category']);
					}
					if(isset($_SESSION['delete-category'])){
						//print session Message
						echo $_SESSION['delete-category'];
						//remove session Message
						unset($_SESSION['delete-category']);
					}
					if(isset($_SESSION['update-category'])){
						//print session Message
						echo $_SESSION['update-category'];
						//remove session Message
						unset($_SESSION['update-category']);
					}
				?>			
			</div>	


			<table class="main-table">
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Image</th>
					<th>Featured</th>
					<th>Active</th>
					<th>Action</th>
				</tr>

				<tr>
					<?php
						// select data from database
						$stmt = $con->prepare("SELECT * FROM category ORDER BY id DESC");
						$stmt->execute();
						$cats = $stmt->fetchAll();

						//display data in table
						foreach ($cats as $cat) {
							echo "<tr>";
								echo "<td>". $cat['id'] ."</td>"; 
								echo "<td>". $cat['title'] ."</td>";
								echo "<td><img src=". SITEURL ."images/category/". ((!empty($cat['image_name']))? $cat['image_name'] : "default_cat.png") ."></img></td>"; 													
								echo "<td>". (($cat['featured'] == '0')? "No" : "Yes") ."</td>";
								echo "<td>". (($cat['active']   == '0')? "No" : "Yes") ."</td>";
								echo "<td><button class='btn'><a href='update-category.php?id=".    $cat['id']  ."'>Edit</a></button> 
										  <button class='btn'><a href='delete-category.php?id=".    $cat['id']  ."&image_name=". $cat['image_name'] ."'>Delete</a> </button>
										   </button>  
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
