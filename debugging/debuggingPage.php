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
					<form method="post" action="">
						<label>Voer hier je naam in</label><br />
						<input type="text" name="input" maxlength="15" autocomplete="off" required autofocus pattern="[A-Za-z]{1,15}" oninvalid="usernameVerify(this);" oninput="usernameVerify(this);">
						<input type="submit" id="submit" name="gebruikersNaamsubmit" value="Submit">
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
					<button>groep 4</button>
					<button>groep 5</button>
					<button>groep 6</button>
				</div>
			</div>
		<!--End Section 2-->
		<!--Section 3 - Operator Select Page -->
			<div id="operators">
				<button>Ga terug</button>
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
			<button>Ga terug</button>
			<div class="text-center div-center">
				 <?php
					for ($a = 1; $a < 21; $a++){
						echo "<button>$a</button>";
					}
				 ?>
			</div>
		</div>
		<!--Section 5 - Assignment Page-->
		<div id="opdrachten">
			<button>Ga terug</button>
			<form class="div-center" method="post" action="" >
				<h1 class="text-center"></h1>
				<div class="text-center">
					<input type="number" name="input" required>
					<input type="submit" id="submit" name="antwoordSubmit" value="Submit">
				</div>
			</form>
		</div>
		<!--End Section 5-->
		<!--Section 6 - Results Page-->
		<div id="uitslag">
			<button>Ga terug</button>
		</div>
		<!--End Section 6-->
	</body>

</html>
