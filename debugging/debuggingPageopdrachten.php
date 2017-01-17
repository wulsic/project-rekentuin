<html>
	<head>
		<title> Debugging Page - Opdrachten </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="javascript/javascript.js"></script>
		<?php require_once("tweeGetallen.php"); $getalEnopdrachtArray = opdrachtGenerator(6 , $operator)?>
	</head>
	<body>
		<h1> <?php  echo $getalEnopdrachtArray[0]; ?> </h1>
		<form method="post" action="">
			<input type="hidden" name="uitkomst" value="<?php echo $getalEnopdrachtArray[1] ?>">
			<input type="text" name="antwoord">
			<input type="submit" name="antwoordSubmit">
		</form>
		<?php
		if (isset($_POST["antwoordSubmit"])){
			$controle = opdrachtControleren($_POST["antwoord"], $_POST["uitkomst"]);
			echo $controle;
			print_r($_POST);
			print_r($getalEnopdrachtArray);
		}
		?>
	</body>
</html>
