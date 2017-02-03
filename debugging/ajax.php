<?php
	session_start();
	require_once("functions.php");
	if (isset($_POST["functions"]))  {
		// Section 1 - Login
		if ($_POST["functions"] == "callLoginsystem"){
			$username = loginSystem($_POST["username"]);
			echo $username;
		}
		// Section 2 - Assign Group
		elseif ($_POST["functions"] == "group"){
			$_SESSION["group"] = $_POST["group"];
		}
		// Section 2 - Assign Operator
		elseif ($_POST["functions"] == "callRekundigeoperator"){
			if ($_POST["operator"] == "Toets"){
				echo AssignmentindexCheckerandGenerator(1);
			}
			if ( isset($_SESSION["operator"])&& !empty($_SESSION["operator"]) ){
				$_SESSION["oldOperator"] = $_SESSION["operator"];
			}
			$_SESSION["operator"] = $_POST["operator"];
		}
		// Section 3 - Assign index and call the generator for the first assignment
		elseif ($_POST["functions"] == "callAssignmentindexCheckerandGenerator") {
			echo AssignmentindexCheckerandGenerator($_POST["index"]);
		}
		// Section 4 - Delete all assignment based on operator
		elseif ($_POST["functions"] == "delete"){
			unset($_SESSION["opdrachtOpslaan"][$_SESSION["operator"]]);
		}
		// Section 5 - Save all variables for later use
		elseif ($_POST["functions"] == "callControlsaveAndassignmentGenerator"){
			$timeStop = time();
			$username = $_SESSION["username"];
			$index = $_SESSION["index"];
			$antwoord = $_POST["antwoord"];
			$som = $_SESSION["opdracht"][0];
			$uitkomst = $_SESSION["opdracht"][1];
			$timestart = $_SESSION["opdracht"][2];
			$timeDifference = $timeStop - $timestart;
			$operator = rekundigeOperator($_SESSION["operator"]);
			$opdrachtControlle = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan = opdrachtOpslaan($operator, $index , $som, $uitkomst, $antwoord, $opdrachtControlle, date("i:s",$timeDifference));
			$indexChecker = indexChecker("");
			if ($indexChecker == "eNumber"){
				echo true;
			}
			//elseif ($operator == "Toets"){
			//	$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], $operator);
			//	echo $_SESSION["opdracht"][0];
			//}
			else {
				$newsom = opdrachtGenerator($_SESSION["group"], $operator);
				$returnArray = json_encode(array($som, $uitkomst, $antwoord, $opdrachtControlle, $username, $newsom[0]));
				echo $returnArray;
				$_SESSION["opdracht"] = $newsom;
			}
		}
		// Section 6 - Iterate array for a nice results table
		elseif ($_POST["functions"] == "results") {
			$operator = $_SESSION["operator"];
			echo "<table>
					<tr>
						<td> $operator </td>
					</tr>
					<tr>
						<td> Opdracht Nummer</td>
						<td> Som </td>
						<td> Uitkomst </td>
						<td> Jouw Antwoord </td>
						<td> Goed of Fout </td>
						<td> Jouw tijd per som </td> 
					</tr>";
			foreach ($_SESSION["opdrachtOpslaan"][$operator] as $key => $value) {
				echo "<tr>
						<td> $key</td>";
				foreach ($value as $key2) {
					echo"<td> $key2 </td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	}
?>