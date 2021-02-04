
<?php include('partials/menu.php');?>
	
	<!-- Start main section -->
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Admin</h1>
			<button class="btn"><a href="add-admin.php">Add New</a></button>
			<div class="div_message_success">
				<?php 
					if(isset($_SESSION['add-admin'])){
						//print session Message
						echo $_SESSION['add-admin'];
						//remove session Message
						unset($_SESSION['add-admin']);
					}
					if(isset($_SESSION['delete-admin'])){
						//print session Message
						echo $_SESSION['delete-admin'];
						//remove session Message
						unset($_SESSION['delete-admin']);
					}
					if(isset($_SESSION['update-admin'])){
						//print session Message
						echo $_SESSION['update-admin'];
						//remove session Message
						unset($_SESSION['update-admin']);
					}
					if(isset($_SESSION['update-pass'])){
						//print session Message
						echo $_SESSION['update-pass'];
						//remove session Message
						unset($_SESSION['update-pass']);
					}									
				?>
			</div>
			<table class="main-table">
				<tr>
					<th>ID</th>
					<th>userName</th>
					<th>FullName</th>
					<th>Action</th>
				</tr>

				<tr>
					<?php
						// select data from database
						$stmt = $con->prepare("SELECT * FROM admin ");
						$stmt->execute();
						$admins = $stmt->fetchAll();

						//display data in table
						foreach ($admins as $admin) {
							echo "<tr>";
							echo "<td>". $admin['id'] ."</td>";
							echo "<td>". $admin['user_name'] ."</td>";
							echo "<td>". $admin['full_name'] ."</td>";
							echo "<td><button class='btn'><a href='update-admin.php?id=".    $admin['id']  ."'>Edit</a></button> 
									  <button class='btn'><a href='delete-admin.php?id=".    $admin['id']  ."'>Delete</a> </button>
									  <button class='btn'><a href='update-password.php?id=". $admin['id']  ."'>Update Password</a> </button>  
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


