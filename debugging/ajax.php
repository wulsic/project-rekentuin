<?php
	session_start();
	require_once("functions.php");
	if (isset($_POST["functions"]))  {
		$functions = $_POST["functions"];
		// Section 1 - Login
		if ($functions == "callLoginsystem"){
			$username = loginSystem($_POST["username"]);
			echo $username;
		}
		// Section 1 - END
		
		// Section 2 - Assign Group
		elseif ($functions == "group"){
			$_SESSION["group"] = $_POST["group"];
		}
		// Section 1 - END
		
		// Section 2 - Assign Operator
		elseif ($functions == "callRekundigeoperator"){
			$_SESSION["oldOperator"] = (isset($_SESSION["operator"])) ? $_SESSION["operator"] : $_POST["operator"];
			$operator 	 = $_POST["operator"];
			$oldOperator = $_SESSION["oldOperator"];
			$_SESSION["operator"] = $_POST["operator"];
			if ($operator == "Toets"){
				echo json_encode(indexCheckerandGenerator(1));
			}
			elseif ($operator == "Resultaten"){
				$_SESSION["operator"] = "Toets";
				echo resultPage();
			}
		}
		// Section 2 - END
		
		// Section 3 - Assign index and call the generator for the first assignment
		elseif ($functions == "callindexCheckerandGenerator") {
			echo json_encode(indexCheckerandGenerator($_POST["index"]));
		}
		
		// Section 4 - Delete all assignment based on operator or operator + index
		elseif ($functions == "delete"){
			$whatToreturn = (isset($_POST["index"])) ? json_encode(deleteAssignments($_POST["index"])) : json_encode(deleteAssignments(null));
			echo $whatToreturn;
		}
		// Section 4 - END
		
		// Section 5 - Save all variables for later use
		elseif ($functions == "callControlsaveAndassignmentGenerator"){
			
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
			
			// Section 5.2 - Call functions.
			$opdrachtControlle = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan   = opdrachtOpslaan($operator, $index , $som, $uitkomst, $antwoord, $opdrachtControlle, date("i:s",$timeDifference));
			$indexChecker 	   = indexChecker("");
			
			// Section 5.3 - Check whether indexChecker returns "eNumber".
			if ($indexChecker == "eNumber"){
				echo json_encode(array("eNumber", resultPage()));
			}
			else {
				$newsom = opdrachtGenerator($_SESSION["group"], rekundigeOperator($operator) );
				$returnArray = ($operator == "Toets" ) ? $newsom[0] : array($som, $uitkomst, $antwoord, $opdrachtControlle, $username, $newsom[0]);
				echo json_encode($returnArray);
				$_SESSION["opdracht"] = $newsom;
			}
		}
		// Section 5 - END
		
		// Section 6 - check whether result page is empty.
		elseif ($functions == "callResultpage"){
			$operator = $_SESSION["operator"];
			if (empty($_SESSION["opdrachtOpslaan"][$operator])){
				echo "eResults"; // empty results
			}
			else {
				echo resultPage();
			}
		}
		// Section 6 - END
	
	}
?>