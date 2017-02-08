<!DOCTYPE html>
<html>
	<head>
		<title> Wulsic W.I.P </title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<?php
			$dir = '/home/u233301266/public_html/';
			$list = array_diff(scandir($dir), array('..', '.', '.htaccess', 'index.php', 'css'));
			echo "<h1 id='title'>HomePage of all kinds of documents</h1>";
			echo "<div id='folderMenu'>";
			foreach ($list as $key) {
				echo "<a href=$key>$key</a>";
			}
			echo "</div>";
		?>
	</body>
</html>
