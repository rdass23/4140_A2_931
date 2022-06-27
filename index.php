<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>A2</title>
</head>
<body>
	<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL); 

	$conn = mysqli_connect("db.cs.dal.ca", "rdass", "PPeGT5XKw8w4u6cnyc4ECehQP", 'rdass');

	?>
	<header>Purchase Ordering</header>

	<!-- ACCORDIAN VIA: https://getbootstrap.com/docs/5.2/components/accordion/ -->
	<div class="accordion m-4 container" id="accordionExample">
		<div class="accordion-item col-4">
			<h2 class="accordion-header" id="headingTwo">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					Toggle Parts List
				</button>
			</h2>
			<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<table>
						<tr>
							<th>Part Number</th>
							<th>Part Name</th>
							<th>Current Price</th>
						</tr>
						<?php 
						$parts = "SELECT * FROM Parts931";
						$result = $conn -> query($parts);

						if ($result-> num_rows > 0) {
							while ($row = $result-> fetch_assoc()){
								echo "<tr><td>".$row["partNo931"]."</td><td>".$row["partName931"]."</td><td>$".$row["currentPrice931"]."</td></tr>";
							}
						}
						else {
							echo "No Results";
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- CREATE A PURCHASE ORDER -->
	<div class="m-4 container">
		<hr> 
		<h2>Create a Purchase Order</h2>
		<form class="col-2" name="poForm" action="" method="post">
			<input type="text" class="form-control" name="clientId" placeholder="Client ID" required>
			<input type="text" class="form-control mt-2" name="status" placeholder="Status" required>
			<button type="submit" class="btn btn-primary my-3" name="submitPo">Search</button>
		</form>
	</div>


	<!-- SEARCH BY PO NUMBER -->
	<div class="m-4 container">
		<hr> 
		<h2>Search for Lines in a PO Order</h2>
		<form class="col-2" name="searchPoForm" action="" method="post">
			<input type="text" class="form-control" name="searchPo" placeholder="PO Number" required>
			<button type="submit" class="btn btn-primary my-3" name="submitPoSearch">Search</button>
		</form>

		<?php 
			if(isset($_POST['submitPoSearch'])){ //check if form was submitted

	  			$poNum = $_POST['searchPo']; //get input text
	  			$lineResult = $conn -> query("SELECT * FROM Lines931 WHERE poNo931 = $poNum");
	  			if ($lineResult !== false && $lineResult-> num_rows > 0) {
	  				?>
	  				<table>
	  					<tr>
	  						<th>PO Number</th>
	  						<th>PO Line Number</th>
	  						<th>Part Number</th>
	  						<th>Quantity</th>
	  						<th>Ordered Price</th>
	  					</tr>
	  					<?php
	  					while ($row = $lineResult-> fetch_assoc()){
	  						echo "<tr><td>".$row["poNo931"]."</td><td>".$row["lineNo931"]."</td><td>".$row["partNo931"]."</td><td>".$row["qty931"]."</td><td>$".$row["priceOrdered931"]."</td></tr>";
	  					}
	  				}
	  				else {
	  					echo "No Results for PO ".$poNum;
	  				}
	  				?>

	  				</table> <?php
	  			} 
	  			?>

	</div>

	<!-- SEARCH BY CLIENT ID -->

	<?php $conn->close(); ?>
</body>
</html>