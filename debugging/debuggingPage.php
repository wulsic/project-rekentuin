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
		<!--Section 2 - Groepen Selectie Pagina -->
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
		<!--Section 3 - Operator Selectie Pagina -->
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
		<!--Section 4 - Opdracht Pagina-->
			<div id="opdrachten">
					<form class="div-center" method="post" action="" onsubmit="answerSend()">
						<h1 class="text-center"></h1>
						<div class="text-center">
							<input type="number" name="antwoord" required>
							<input type="submit" id="submit" name="antwoordSubmit">
						</div>
					</form>
			</div>
		<!--End Section 4-->
	</body>

</html>
