
<?php include('partials/menu.php'); ?>
	
	<!-- Start main section -->
	<div class="main-content">
		<div class="wrapper">
			<h1>DASHBOARD</h1>

		
			<div>				
				<div class="col-4">
					<?php
						$stmt = $con->prepare("SELECT id FROM category");
						$stmt->execute();
						$count = $stmt->rowCount();
					?>
					<h1><?php echo $count ?></h1>
					</br>
					categories	
				</div>


				<div class="col-4">
					<?php
						$stmt = $con->prepare("SELECT id FROM food");
						$stmt->execute();
						$count = $stmt->rowCount();
					?>					
					<h1><?php echo $count ?></h1>
					</br>
					Foods
				</div>				

				<div class="col-4">
					<?php
						$stmt = $con->prepare("SELECT id FROM t_order");
						$stmt->execute();
						$count = $stmt->rowCount();
					?>					
					<h1><?php echo $count ?></h1>
					</br>
					Orders	
				</div>

				<div class="col-4">
					<?php
						$stmt = $con->prepare("SELECT SUM(total) AS total FROM t_order WHERE status = 'Delivered'");
						$stmt->execute();
						$total = $stmt->fetch();
					?>						
					<h1>$<?php echo $total['total'] ?></h1>
					</br>
					Total Revenue	
				</div>				
			</div>
			<dir class="clearfix"></dir>
		</div>			
	</div>
	<!-- end   main section -->

<?php include('partials/footer.php')?>
