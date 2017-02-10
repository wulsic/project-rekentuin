<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/style.php" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
					<input type="text" name="input" maxlength="14" autocomplete="off" required autofocus pattern="[A-Za-z]{1,15}" oninvalid="usernameVerify(this);" oninput="usernameVerify(this);">
					<input type="submit" id="submit" name="gebruikersNaamsubmit" value="Submit">
				</form>
				<div id="buttons">
					<button class="popup" id="over">Over school</button>
					<button class="popup" id="uitleg">Klik hier voor uitleg :)</button>
				</div>
				
				<!-- Section 1.1 - About School Popup -->
				<div id="overmodal" class="modal">
					<div class="modal-content">
						<span class="close">&times;</span>
						<p>Text over school</p>
					</div>
				</div>
				
				<!-- Section 1.2 - Explaination about the usage of the page -->
				<div id="uitlegmodal" class="modal">
					<div class="modal-content">
						<span class="close">&times;</span>
						<p>Text over uitleg</p>
					</div>
				</div>
			</div>
			
		<!--Section 1 - END-->
		
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
		<!--Section 2 - END->
		
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
				<!-- Section 4.1 - Test already made response popup -->
				<div id="operatorsmodal" class="modal">
					<div class="modal-content modal-medium">
						<button id="yesOrno">Ja</button>
						<button id="yesOrno">Nee</button>
						<button id="resultatenKnop">Resultaten</button>
					</div>
				</div>
			</div>
		<!--Section 3 - END-->
		
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
						echo "<button>$a</button>";
					}
					echo "</div>"
				 ?>
			</div>
			<!-- Section 4.1 - Assignment already made response popup -->
			<div id="opdrachtenSelectiemodal" class="modal">
				<div class="modal-content modal-medium">
					<span class="close">&times;</span>
					<button id="yesOrno">Ja</button>
					<button id="yesOrno">Nee</button>
				</div>
			</div>
		</div>
		<!--Section 4 - END-->
		
		<!--Section 5 - Assignment Page-->
		<div id="opdrachten">
			<button class="backwards">Ga terug</button>
			<form class="div-center text-center" method="post" action="" >
				<h1 class="text-center"></h1>
				<input type="number" name="input" autocomplete="off" required>
				<input type="submit" id="submit" name="antwoordSubmit" value="Submit">
			</form>
			
			<!-- Section 5.1 - Answer response popup -->
			<div id="opdrachtenmodal" class="modal">
				<div class="modal-content modal-small">
					<span class="close">&times;</span>
				</div>
			</div>
		</div>
		<!--Section 5 - END-->
		
		<!--Section 6 - Results Page-->
		<div id="uitslag">
			<button class="backwards">Ga terug</button>
		</div>
		<!--Section 6 - END-->
		
	</body>
</html>