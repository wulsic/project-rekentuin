<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/style.php" rel="stylesheet" type="text/css">
		<title> Debugging Page - Opdrachten </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="javascript/javascript.js"></script>
	</head>
	<body>
		<!--Section 1 - Startpagina -->
			<div id="startpagina">
				<h1> Rekentuin </h1>
					<form id="startpaginaForm" method="post" action="" onsubmit="send()">
						Voer hier je naam <br />
						<input type="text" name="gebruikersNaam">
						<input type="submit" id="submit" name="gebruikersNaamsubmit">
					</form>
				<div class="flex-direction-column">
					<button>Over school</button>
					<button>Klik hier voor uitleg :)</button>
				</div>

			</div>
				<?php
				echo $array;
				print_r($_POST);
				?>
		<!--End Section 1-->
	</body>

</html>
