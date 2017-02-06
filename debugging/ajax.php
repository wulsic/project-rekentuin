<?php
	session_start();
	require_once("functions.php");
	if (isset($_POST["functions"]))  {
		// Section 1 - Login
		if ($_POST["functions"] == "callLoginsystem"){
			$username = loginSystem($_POST["username"]);
			echo $username;
		}
		// Section 1 - END
		
		// Section 2 - Assign Group
		elseif ($_POST["functions"] == "group"){
			$_SESSION["group"] = $_POST["group"];
		}
		// Section 1 - END
		
		// Section 2 - Assign Operator
		elseif ($_POST["functions"] == "callRekundigeoperator"){
			$_SESSION["operator"] = $_POST["operator"];
			if ($_POST["operator"] == "Toets"){
				echo indexCheckerandGenerator(1);
			}
			elseif (isset($_SESSION["operator"])&& !empty($_SESSION["operator"])){
				$_SESSION["oldOperator"] = $_SESSION["operator"];
			}
		}
		// Section 2 - END
		
		// Section 3 - Assign index and call the generator for the first assignment
		elseif ($_POST["functions"] == "callindexCheckerandGenerator") {
			echo json_encode(indexCheckerandGenerator($_POST["index"]));
		}
		
		// Section 4 - Delete all assignment based on operator or operator + index
		elseif ($_POST["functions"] == "delete"){
			if ($_POST["index"] != null){
				unset($_SESSION["opdrachtOpslaan"][$_SESSION["operator"]][$_SESSION["index"]]);
				$_SESSION["index"] = $_POST["index"];
				$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], rekundigeOperator($_SESSION["operator"]));
				echo $_SESSION["opdracht"][0];
			}
			else {
				unset($_SESSION["opdrachtOpslaan"][$_SESSION["operator"]]);				
			}
		}
		// Section 4 - END
		
		// Section 5 - Save all variables for later use
		elseif ($_POST["functions"] == "callControlsaveAndassignmentGenerator"){
			// Section 5.1 - Put all sessions / post / time into a more readable variable
			$timeStop 		= time();
			$antwoord 		= $_POST["antwoord"];
			$index 			= $_SESSION["index"];
			$username 		= $_SESSION["username"];
			$operator 		= $_SESSION["operator"];
			$som			= $_SESSION["opdracht"][0];
			$uitkomst 		= $_SESSION["opdracht"][1];
			$timestart 		= $_SESSION["opdracht"][2];
			$timeDifference = $timeStop - $timestart;
			
			// Section 5.2 - Put all those lovely variables into functions.
			$opdrachtControlle = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan   = opdrachtOpslaan($operator, $index , $som, $uitkomst, $antwoord, $opdrachtControlle, date("i:s",$timeDifference));
			$indexChecker 	   = indexChecker("");
			
			// Section 5.3 - Check whether indexChecker returns "eNumber".
			if ($indexChecker == "eNumber"){
				echo true;
			}
			else {
				$newsom = opdrachtGenerator($_SESSION["group"], rekundigeOperator($operator) );
				$returnArray = ($operator == "Toets" ) ? $newsom[0] : json_encode(array($som, $uitkomst, $antwoord, $opdrachtControlle, $username, $newsom[0]));
				echo $returnArray;
				$_SESSION["opdracht"] = $newsom;
			}
		}
		// Section 5 - END
		
		// Section 6 - Iterate array where all the assignment are saved for a nice results table
		elseif ($_POST["functions"] == "results") {
			$operator = $_SESSION["operator"];
			echo "<table>
					<tr>
						<td> $operator </td>
					</tr>
					<tr>
						<td> Opdracht </td>
						<td style='padding-right:20px;'> Som </td>
						<td style='padding-right:20px;'> </td>
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
		// Section 6 - END
	}
?>