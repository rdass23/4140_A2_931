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
	?>
	<header>Purchase Ordering</header>

	<div class="accordion m-4 container" id="accordionExample">
		<div class="accordion-item col-4">
			<h2 class="accordion-header" id="partsList">
				<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					List of Parts
				</button>
			</h2>
			<div id="collapseOne" class="accordion-collapse collapse hide" aria-labelledby="partsList" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<table>
						<tr>
							<th>Part Number</th>
							<th>Part Name</th>
							<th>Current Price</th>
						</tr>
						<?php 

						$conn = mysqli_connect("db.cs.dal.ca", "rdass", "PPeGT5XKw8w4u6cnyc4ECehQP", 'rdass');
						$parts = "SELECT * FROM Parts931";
						$result = $conn -> query($parts);

						if ($result-> num_rows > 0) {
							while ($row = $result-> fetch_assoc()){
								echo "<tr><td>".$row["partNo931"]."</td><td>".$row["partName931"]."</td><td>$".$row["currentPrice931"]."</td></tr>";
							}
						}
						else {
							echo "No Results";
						}$conn->close();
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>