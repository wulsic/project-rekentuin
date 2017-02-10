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
							echo "<td> $key2</td>";
							echo "<tr>";
							foreach ($value2 as $key3 => $value3){
								echo "<td> $key3</td>";
								foreach ($value3 as $key4 => $value4){
									echo "<td> $value4</td>";
								}
						echo "</tr>";
							}
						}
					}
				}
	echo "</table>";
	$debugW = 1;
	if ($debugW == 1){
		$fouten             = 0;
		$operator           = $_SESSION["operator"]; 
		$opdrachtOpslaan    = $_SESSION["opdrachtOpslaan"];
		$CountedAssignments = count($opdrachtOpslaan[$operator]);
		
		//print_r ($_SESSION["opdrachtOpslaan"]);
		echo "<br />";
		echo "Test";
		//print_r (array_keys($_SESSION["opdrachtOpslaan"]));
		print_r ($opdrachtOpslaan[$operator][1]);
		echo "<br />";
		//echo $_SESSION["opdrachtOpslaan"]["Toets"][1][4];
		

		for ($x = 1; $x < $CountedAssignments; $x++){
			if ($opdrachtOpslaan[$operator][$x][4] == "fout"){
				$fouten++;
			}
		}
		$cijfer = 10 - ($fouten * 0.5);
		
		// 10 is default number if the pupil has 0 faults, the formula will be: (10 - (number of faults * 0.5))
		
		echo $CountedAssignments;
	}
	echo "<br/><br />";
	//foreach ($_SESSION[opdrachtOpslaan] as $key){
	//	echo $key;
	//}
?>