<?php
	session_start();
	echo "<br/>
			<table>";
				foreach ($_SESSION as $key => $value) {
					if ($key == "username" || $key == "operator" || $key == "oldOperator" || $key == "group" || $key == "index" || $key == "som" || $key == "uitkomst" || $key == "timestart"){
					echo "<tr>
						<td> $key</td>
						<td> $value</td>";
					echo "</tr>";	
					}
					elseif ($key == "numbers"){
						echo "<tr>
							<td> $key</td>";
						foreach ($value as $key2){
							echo "<td> $key2</td>";
						}
						echo "</tr>";						
					}
					elseif ($key == "opdrachtOpslaan"){
						echo "<tr>
							<td> $key</td>";
						echo "</tr>";
						foreach ($value as $key2 => $value2){
							echo "<tr>";
							echo "<td> $key2</td>";
							echo "</tr>";
							foreach ($value2 as $key3 => $value3){
								echo "<tr>";
								echo "<td> $key3</td>";
								echo "</tr>";
								foreach ($value3 as $key4 => $value4){
									echo "<tr>";
									echo "<td> $key4</td>";
									foreach ($value4 as $key5 => $value5){
										echo "<td> $value5</td>";
									}
								}
						echo "</tr>";
							}
						}
					}
				}
	echo "</table>";
	echo "<br />";
	if (isset($_SESSION["opdrachtOpslaan"])){
		$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
		$opdrachtOftoets = $_SESSION["opdrachtOftoets"];
		$operator = $_SESSION["operator"];
		$array_column = array_column($opdrachtOpslaan[$opdrachtOftoets][$operator], 4);
		echo "array column: ";
		print_r($array_column);
		$array_keys = array_keys(array_column($opdrachtOpslaan[$opdrachtOftoets][$operator], 4), "fout");
		echo "<br/> array keys: ";
		print_r($array_keys);
		$fouten = count(array_keys(array_column($opdrachtOpslaan[$opdrachtOftoets][$operator], 4), "fout"));
		$c = 10 - ($fouten * 0.5); //Var C is Het cijfer
		if ($c == 10){
			$reactie = "School heeft geen zin meer voor jou.";
		}
		elseif ($c >= 8 && $c < 10){
			$reactie = "Wauw! Dat heb je goed gemaakt!";
		}
		elseif ($c >= 6 && $c < 8){
			$reactie = "Goed gedaan!";
		}
		elseif ($c >= 5.5 && $c < 6){
			$reactie = "Je deed het goed maar nog een beetje bij spijkeren";
		}
		elseif ($c >= 4 && $c < 5.5){
			$reactie = "Net niet goed, jammer. Blijf oefenen";
		}
		elseif ($c >= 0 && $c < 4){
			$reactie = "Maak de oefeningen goed overnieuw en probeer nogmaals";
		}
		echo "<br/>" . $fouten . " fouten. <br/> Cijfer: " . $c . "<br/> Reactie: " . $reactie;
	}
?>
<hr />
<pre>
<p> Session hiearchy </p>
<?php
 print_r($_SESSION);
?>
</pre>