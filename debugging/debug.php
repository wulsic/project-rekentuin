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
?>