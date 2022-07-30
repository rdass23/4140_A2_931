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

	$conn = mysqli_connect("localhost", "mamp", "", 'rdass');

	?>
	<header><a href="index.php" class="text-decoration-none text-white">Assingment 2</a></header>

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
						<?php 
						$parts = "SELECT * FROM Parts931";
						$result = $conn -> query($parts);

						if ($result-> num_rows > 0) {
							while ($row = $result-> fetch_assoc()){
								echo "<tr>
							<th>Part Number</th>
							<th>Part Name</th>
							<th>Current Price</th>
						</tr><tr><td>".$row["partNo931"]."</td><td>".$row["partName931"]."</td><td>$".$row["currentPrice931"]."</td></tr>";
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
	<!-- END OF ACCORDION -->

	<!-- CREATE A PURCHASE ORDER -->
	<div class="m-4 container">
		<hr> 
		<div class="row gx-5">
			<h1 class="text-center mb-5">Purchase Ordering System</h1>
			<div class="col-5">
				<h3>Create a Purchase Order</h3>
				<p>Create a purchase order by entering your client id number. A purchase order number, purchase order date, and status will automatically be added to your purchase order once created.</p>
				<form class="col-7" name="poForm" action="" method="post">
					<input type="text" class="form-control" name="clientId931" placeholder="Client ID" required>
					<button type="submit" class="btn btn-primary my-3" name="submitPo931">Create Purchase Order</button>
				</form>
				<?php 
					if(isset($_POST['submitPo931'])){ //check if form was submitted
						$clientId = $_POST['clientId931']; //get client input text

						// check if client id exists in database
						$sqlCheck = $conn -> query("SELECT * FROM Clients931 WHERE clientId931 = $clientId");
						// when client exists, create purchase order
						if($sqlCheck !== false && $sqlCheck -> num_rows > 0)
						{
							$date = date("Y-m-d");
							if ($conn -> query("INSERT INTO POs931 (clientCompID931, dateOfPO931, status931) VALUES('$clientId', '$date', 'in progress')") === TRUE) {
								$poId = $conn -> insert_id;
								echo "<script>alert('Purchase order successfully created! Your PO number is ".$poId."');</script>";
							} else {
								echo "Error creating purchase order.";
							}
						}
						// when client does not exist give alert
						else
						{
							echo "<script>alert('Client ID does not exist, cannot create purchase order');</script>";
						}
					}
					?>
				</div>
				<div class="col-7">
					<h3>Add Line to a Purchase Order</h3>
					<p>After creating a purchase order, add a line to it by specifying the PO number, which part you want, the quantity of that part and the price for that part. Repeat for each different part you want.</p>
					<form class="col-6" name="poForm" action="" method="post">
						<input type="text" class="form-control" name="poNum931" placeholder="PO Number" required>
						<input type="text" class="form-control mt-2" name="partNo931" placeholder="Part Number" required>
						<input type="text" class="form-control mt-2" name="qty931" placeholder="Quantity" required>
						<input type="text" class="form-control mt-2" name="currPrice931" placeholder="Current Price" required>
						<button type="submit" class="btn btn-primary my-3" name="submitLine931">Add Line</button>
					</form>
					<?php
					if (isset($_POST['submitLine931'])){
						$poNumLine = $_POST['poNum931']; // get po num input text
						$partNum = $_POST['partNo931']; // get part num input text
						$qty = $_POST['qty931']; // get qty input text
						$price = $_POST['currPrice931']; // get price input text

						// create a variable to keep track of errors
						$errors = 0;

						// check if PO Num exists
						$poNumCheck = $conn -> query("SELECT * FROM POs931 WHERE poNo931 = $poNumLine");
						// when PO Num doesnt exist, add 1 to errors
						if($poNumCheck !== true && $poNumCheck -> num_rows <= 0){
							$errors = $errors + 1;
							echo "PO Number ".$poNumLine." does not exist.<br/>";

						}

						// check if part number exists
						$partNumCheck = $conn -> query("SELECT * FROM Parts931 WHERE partNo931 = $partNum");
						// when PO Num doesnt exist, add 1 to errors
						if($partNumCheck !== true && $partNumCheck -> num_rows <= 0){
							$errors = $errors + 1;
							echo "Part Number ".$partNum." does not exist.<br/>";
						} else{
							// only check for quanity if part number exists
							$quantityCheck = $conn -> query("SELECT qoh931 FROM Parts931 WHERE partNo931 = $partNum");
							if ($quantityCheck->num_rows > 0) {
							  while($row = $quantityCheck->fetch_assoc()) {
							    if ($row["qoh931"] < $qty){
							    	$errors = $errors + 1;
							    	echo "Not enough quanity available. Part ".$partNum." only has ".$row["qoh931"]." left.<br/>";
							    }
							  }
							}

							// only check for price if part number exists
							$priceCheck = $conn -> query("SELECT currentPrice931 FROM Parts931 WHERE partNo931 = $partNum");
							if ($priceCheck->num_rows > 0) {
							  while($row = $priceCheck->fetch_assoc()) {
							    if ($row["currentPrice931"] !== $price){
							    	$errors = $errors + 1;
							    	echo "The current price of part ".$partNum." and entered price do not match.";
							    }
							  }
							}
						}

						// If all checks have passed (so errors still equals 0) submit form data to db
						if ($errors === 0){
							// find number of lines in PO
	  						$lineCheck = $conn -> query("SELECT * FROM Lines931 WHERE poNo931 = $poNumLine");
	  						$lineNum = $lineCheck->num_rows + 1;
	  						
							if ($conn -> query("INSERT INTO Lines931 (poNo931, lineNo931, partNo931, qty931, priceOrdered931) VALUES('$poNumLine', '$lineNum', '$partNum', '$qty', '$price')") === TRUE) {
								echo "<script>alert('Line successfully added to your PO!');</script>";
								
							} else {
								echo "Error adding line to purchase order. ".$conn->error;
							}
						}
					} 
					?>
					</div>
				</div>
			</div>
			<!-- END OF CREATE PURCHASE ORDER -->


			<!-- SEARCH BY PO NUMBER -->
			<div class="m-4 container">
				<hr> 
				<h3>Search for Lines in a Purchase Order</h3>
				<p>Enter a PO number and a list of lines in that PO will be returned.</p>
				<form class="col-2" name="searchPoForm" action="" method="post">
					<input type="text" class="form-control" name="searchPo931" placeholder="PO Number" required>
					<button type="submit" class="btn btn-primary my-3" name="submitPoSearch931">Search</button>
				</form>

				<?php 
			if(isset($_POST['submitPoSearch931'])){ //check if form was submitted

	  			$poNum = $_POST['searchPo931']; //get input text
	  			$lineResult = $conn -> query("SELECT * FROM Lines931 WHERE poNo931 = $poNum");
	  			// when lines for a PO num exist
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
  						// check if PO num exists in PO table
	  					$poCheck = $conn -> query("SELECT * FROM POs931 WHERE poNo931 = $poNum");
	  					if ($poCheck !== false && $poCheck -> num_rows > 0) {
	  						echo "No lines found in PO ".$poNum;
	  					}
  						// if PO doesn't exist at all tell user
	  					else{
	  						echo "PO ".$poNum." does not exist!";
	  					}
	  				}
	  				?></table> <?php
	  			} 
	  			?>
	  		</div>
	  		<!-- END OF SEARCH BY PO NUMBER -->

	  		<!-- SEARCH BY CLIENT ID -->
			<div class="m-4 container">
				<hr> 
				<h3>Search for Purchase Orders by Client ID</h3>
				<p>Enter a Client ID and a list of purchase orders made by the client will be returned.</p>
				<form class="col-2" name="searchClientForm" action="" method="post">
					<input type="text" class="form-control" name="searchClient931" placeholder="Client ID" required>
					<button type="submit" class="btn btn-primary my-3" name="submitClientSearch931">Search</button>
				</form>

				<?php 
			if(isset($_POST['submitClientSearch931'])){ //check if form was submitted

	  			$client = $_POST['searchClient931']; //get input text
	  			$lineResult = $conn -> query("SELECT * FROM POs931 WHERE clientCompID931 = $client");
	  			// when lines for a PO num exist
	  			if ($lineResult !== false && $lineResult-> num_rows > 0) {
	  				?>
	  				<table>
	  					<tr>
	  						<th>PO Number</th>
	  						<th>Client ID</th>
	  						<th>Date Ordered</th>
	  						<th>Status</th>
	  					</tr>
	  					<?php
	  					while ($row = $lineResult-> fetch_assoc()){
	  						echo "<tr><td>".$row["poNo931"]."</td><td>".$row["clientCompID931"]."</td><td>".$row["dateOfPO931"]."</td><td>".$row["status931"]."</td></tr>";
	  					}
	  				}
	  				else {
  					// check if Client ID exists in Clients table
	  					$clientCheck = $conn -> query("SELECT * FROM Clients931 WHERE clientId931 = $client");
	  					if ($clientCheck !== false && $clientCheck -> num_rows > 0) {
	  						echo "No purchase orders made by client with client ID ".$client;
	  					}
  					// if client doesn't exist at all tell user
	  					else{
	  						echo "Client ID ".$client." does not exist!";
	  					}
	  				}
	  				?></table> <?php
	  			} 
	  			?>
	  		</div>
	  		<!-- END OF SEARCH BY CLIENT ID -->


	  		<?php $conn->close(); ?>


	  		<!-- Basic Bootstrap footer via:https://mdbootstrap.com/docs/standard/navigation/footer/ -->
	  		<footer class="bg-light text-center mt-5">
	  			<div class="text-center p-3" style="background-color: darkgrey;">
	  				© 2022 Advanced Database Systems
	  			</div>
	  		</footer>
	  	</body>
	  	</html>