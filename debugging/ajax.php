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
				$operator = $_POST["operator"];
				$isNull = ($operator == null) ? null : setOperator($operator);
			if ($operator == "Toets"){
				$_SESSION["opdrachtOftoets"] = "Toets";
				$testPage = testPage();
				echo json_encode($testPage);
			}
			elseif ($operator == "Resultaten"){
				echo json_encode(array("table", resultPage()));
			}
			else {
				$_SESSION["opdrachtOftoets"] = "Opdracht";
				if (isset($_SESSION["opdrachtOpslaan"])){
					
					$whatToreturn	 = array(0 => "colour");
					$group			 = $_SESSION["group"];
					$operator		 = $_SESSION["operator"];
					$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
					$opdrachtOftoets = $_SESSION["opdrachtOftoets"];
					
					foreach ($opdrachtOpslaan[$group][$opdrachtOftoets][$operator] as $key => $value){
						if (in_array("goed",$value)){
							$whatToreturn[1][$key] = "green";
						}
						else {
							$whatToreturn[1][$key] = "red";
						}
					}
				}
				else {
					$whatToreturn = array(0 => "empty");
				}
				echo json_encode($whatToreturn);
			}
		}
		// Section 2 - END
		
		// Section 3 - Assign index and call the generator for the first assignment
		elseif ($functions == "callindexCheckerandGenerator") {
				echo ($_POST["index"] == "Oefentoets") ? json_encode(oefenToets()) : json_encode(indexCheckerandGenerator($_POST["index"]));
		}
		
		// Section 4 - Delete all assignment based on operator or operator + index
		elseif ($functions == "delete"){
			if ($_POST["index"] == "oefentoets"){
				$_SESSION["opdrachtOftoets"] = "Oefentoets";
			}
			echo $whatToreturn = (isset($_POST["index"])) ? json_encode(deleteAssignments($_POST["index"])) : json_encode(deleteAssignments(null));
		}
		// Section 4 - END
		
		// Section 5 - Save all variables for later use
		elseif ($functions == "callControlsaveAndassignmentGenerator"){
			
			// Section 5.1 - Put all sessions / post / time into a more readable variable
			$timeStop 		 = time();
			$antwoord 		 = $_POST["antwoord"];
			$index 			 = $_SESSION["index"];
			$group			 = $_SESSION["group"];
			$username 		 = $_SESSION["username"];
			$operator 		 = $_SESSION["operator"];
			$som			 = $_SESSION["opdracht"][0];
			$uitkomst 		 = $_SESSION["opdracht"][1];
			$timestart 		 = $_SESSION["opdracht"][2];
			$opdrachtOftoets = $_SESSION["opdrachtOftoets"];
			$timeDifference  = $timeStop - $timestart;
		
			// Section 5.2 - Call functions.
			$opdrachtControle  = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan   = opdrachtOpslaan($group, $opdrachtOftoets, $operator, $index , $som, $uitkomst, $antwoord, $opdrachtControle, date("i:s",$timeDifference));		
			$indexChecker 	   = indexChecker("");
			
			// Section 5.3 - Generate text base of right or wrong of the assignments.
			if ($operator != "Toets"){
				if ($opdrachtControle == "goed"){
					$text = "<p>Goedzo {$username} jouw antwoord is goed! {$som} = {$uitkomst} </p>" ;	
				}
				else {
					$text = "<p>Helaas {$username} jouw antwoord is niet goed. {$som} = {$uitkomst} </p>" ;
				}
			}
			
			// Section 5.4 - Check whether indexChecker returns "eNumber".
			if ($indexChecker == "eNumber"){
				echo json_encode(array("table", resultPage()));
				$_SESSION["opdrachtOftoets"] = "Opdracht";
			}
			else {
				$newsom = opdrachtGenerator($_SESSION["group"], rekundigeOperator($operator) );
				$returnArray = ($operator == "Toets") ?  $newsom[0] : array($newsom[0], $text);
				echo json_encode($returnArray);
				$_SESSION["opdracht"] = $newsom;
			}
		}
		// Section 5 - END
		
		// Section 6 - Move to assignment page based on the operator when the timer runs out.
		elseif ($functions == "callTomoveAssignment"){
			$group	  					 = $_SESSION["group"];
			$operator 					 = $_POST["operator"];
			$opdrachtOftoets 	 		 = $_SESSION["opdrachtOftoets"];
			$_SESSION["opdrachtOftoets"] = "Opdracht";
			unset($_SESSION["opdrachtOpslaan"][$group][$opdrachtOftoets][$operator]);
			setOperator($operator);
		}
		// Section 6 - END
		
		// Section 7 - check whether result page is empty.
		elseif ($functions == "callResultpage"){
			/*$group			 = $_SESSION["group"];
			$operator 		 = $_SESSION["operator"];
			$opdrachtOftoets = $_SESSION["opdrachtOftoets"];
			if (empty($_SESSION["opdrachtOpslaan"][$group][$opdrachtOftoets][$operator])){
				echo json_encode(array("popup", "<p> Je hebt nog geen resultaten. </p>")); // empty results, echo popup and text;
			}
			else {
				$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
				if (count($opdrachtOpslaan[$group][$opdrachtOftoets][$operator]) != 20){
					echo json_encode(array("popup", "<p> Je hebt nog niet alle opdrachten gemaakt. </p>")); // echo popup and text whenever the total made assingments is not 20
				}
				else {*/
					$table = resultPage();
					/*if (isset($opdrachtOpslaan[$group]["Oefentoets"][$operator])){
						$_SESSION["opdrachtOftoets"] = "Oefentoets";
						$table .= resultPage();
						$_SESSION["opdrachtOftoets"] = "Opdracht";						
					}*/
					echo json_encode(array("table", $table));
				/*}
			}*/
		}
		// Section 7 - END
	}
?>