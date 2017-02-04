<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/style.php" rel="stylesheet" type="text/css">
		<title> Debugging Page - Opdrachten </title>
		<!-- jquery version 3.1.1-->
		<script src="javascript/jquery.min.js"></script>
		<script src="javascript/javascript.js?rv=<timestamp+random_value>"></script>
	</head>
	<body>
		<!--Section 1 - Startpagina -->
			<div id="startpagina">
				<h1 class="text-center"> Rekentuin </h1>
				<form method="post" action="">
					<label>Voer hier je naam in</label><br />
					<input type="text" name="input" maxlength="15" autocomplete="off" required autofocus pattern="[A-Za-z]{1,15}" oninvalid="usernameVerify(this);" oninput="usernameVerify(this);">
					<input type="submit" id="submit" name="gebruikersNaamsubmit" value="Submit">
				</form>
				<div id="buttons">
					<button class="popup" id="over">Over school</button>
					<button class="popup" id="uitleg">Klik hier voor uitleg :)</button>
				</div>
				
				<!-- Over Section
				<div id="overModal" class="modal">
					<div class="modal-content">
						<span class="overclose close">&times;</span>
						<p>Text over school</p>
					</div>
				</div>-->
				
				<!-- Uitleg Section
				<div id="uitlegModal" class="modal">
					<div class="modal-content">
						<span class="uitlegclose close">&times;</span>
						<p>Text over uitleg</p>
					</div>
				</div>-->
			</div>
			
		<!--End Section 1-->
		<!--Section 2 - Groepen Select Page -->
			<div id="groepen">
				<h1 class="text-center"></h1>
				<h1 class="text-center"> kies je groep </h1>
				<div class="text-center div-center">
					<button>groep 4</button>
					<button>groep 5</button>
					<button>groep 6</button>
				</div>
			</div>
		<!--End Section 2-->
		<!--Section 3 - Operator Select Page -->
			<div id="operators">
				<button class="backwards">Ga terug</button>
				<h1 class="text-center"> kies je oefening </h1>
				<div class="text-center div-center">
					<button>+</button>
					<button>-</button>
					<button>:</button>
					<button>x</button>
					<button>Toets</button>
				</div>
			</div>
		<!--End Section 3-->
		<!--Section 4 - Assigment Select Page -->
		<div id="opdrachtenSelectie">
			<div class="flex-direction-row flex-justify-space-between">
				<button class="backwards">Ga terug</button>
				<button id="restart">Opnieuw beginnen</button>
				<button id="results">Resultaten</button>
			</div>
			<div class="text-center div-center flex-direction-row flex-justify-space-around">
				 <?php
					for ($a = 1; $a <= 20; $a++){
						if ($a == 1) {
							echo "<div>";
						}
						elseif ($a == 6) {
							echo"</div> <div>";
						}
						elseif ($a == 11) {
							echo "</div> <div>";
						}
						elseif ($a == 16) {
							echo "</div> <div>";
						}
						echo "<button>$a</button>";
					}
					echo "</div>"
				 ?>
			</div>
		</div>
		<!--Section 5 - Assignment Page-->
		<div id="opdrachten">
			<button class="backwards">Ga terug</button>
			<form class="div-center text-center" method="post" action="" >
				<h1 class="text-center"></h1>
				<input type="number" name="input" autocomplete="off" required>
				<input type="submit" id="submit" name="antwoordSubmit" value="Submit">
			</form>
			<!-- Answer Control Section -->
			<div id="controlModal" class="modal">
				<div class="modal-content">
					<span class="overclose close">&times;</span>
					<p>Text over school</p>
				</div>
			</div>
			<!-- Answer Control Section - END -->
		</div>
		<!--End Section 5-->
		<!--Section 6 - Results Page-->
		<div id="uitslag">
			<button class="backwards">Ga terug</button>
		</div>
		<!--End Section 6-->
	</body>
</html>