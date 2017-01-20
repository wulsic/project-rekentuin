<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/style.php" rel="stylesheet" type="text/css">
		<title> Debugging Page - Opdrachten </title>
		<!-- jquery version 3.1.1-->
		<script src="jquery.min.js"></script>
		<script src="javascript/javascript.js"></script>
		<?php session_start(); ?>
	</head>
	<body>
		<!--Section 1 - Startpagina -->
			<div id="startpagina">
				<h1 class="text-center"> Rekentuin </h1>
					<form id="startpaginaForm" method="post" action="" onsubmit="send()">
						Voer hier je naam <br />
						<input type="text" name="gebruikersNaam" required>
						<input type="submit" id="submit" name="gebruikersNaamsubmit">
					</form>
				<div class="flex-direction-column">
					<button>Over school</button>
					<button>Klik hier voor uitleg :)</button>
				</div>
			</div>
		<!--End Section 1-->
			<div id="groepen">
				
			</div>

	</body>

</html>
