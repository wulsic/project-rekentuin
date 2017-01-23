<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/style.php" rel="stylesheet" type="text/css">
		<title> Debugging Page - Opdrachten </title>
		<!-- jquery version 3.1.1-->
		<script src="javascript/jquery.min.js"></script>
		<script src="javascript/javascript.js"></script>
		<?php session_start(); ?>
	</head>
	<body>
		<!--Section 1 - Startpagina -->
			<div id="startpagina">
				<h1 class="text-center"> Rekentuin </h1>
					<form method="post" action="" onsubmit="send()">
						<label>Voer hier je naam in</label><br />
						<input type="text" name="gebruikersNaam" maxlength="16" required>
						<input type="submit" id="submit" name="gebruikersNaamsubmit">
					</form>
				<div id="buttons">
					<button>Over school</button>
					<button>Klik hier voor uitleg :)</button>
				</div>
			</div>
		<!--End Section 1-->
		<!--Section 2 - Groepen Select Page -->
			<div id="groepen">
				<h1 class="text-center"></h1>
				<h1 class="text-center"> kies je groep </h1>
				<div class="text-center div-center">
					<button onclick="groepen('4')">groep 4</button>
					<button onclick="groepen('5')">groep 5</button>
					<button onclick="groepen('6')">groep 6</button>
				</div>
			</div>
		<!--End Section 2-->
		<!--Section 3 - Operator Select Page -->
			<div id="operators">
				<h1 class="text-center"> kies je oefening </h1>
				<div class="text-center div-center">
					<button onclick="operators('+')"> + </button>
					<button onclick="operators('-')"> - </button>
					<button onclick="operators(':')"> : </button>
					<button onclick="operators('x')"> x </button>
					<button onclick="operators('')"> Toets </button>
				</div>
			</div>
		<!--End Section 3-->
		<!--Section 4 - Assigment Select Page -->
		<div id="opdrachtenSelectie">
			<div class="flex-direction-row">
				 <?php
					for ($a = 1; $a < 21; $a++){
						echo "<button onclick='select($a)'> $a </button>";
					}
				 ?>
			</div>
		</div>
		<!--End Section 4-->
		<!--Section 5 - Assignment Page-->
			<div id="opdrachten">
				<form class="div-center" method="post" action="" onsubmit="answerSend()">
					<h1 class="text-center"></h1>
					<input type="number" name="antwoord" required>
					<input type="submit" id="submit" name="antwoordSubmit">
				</form>
			</div>
		<!--End Section 5-->
	</body>

</html>
