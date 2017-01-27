<?php
	session_start();
	// Global Section 1 - Ajax
	if (isset($_POST["functions"]))  {
		if ($_POST["functions"] == "callLoginsystem"){
			$username = loginSystem($_POST["username"]);
			echo $username;
		}
		elseif ($_POST["functions"] == "group"){
			$_SESSION["group"] = $_POST["group"];
		}
		elseif ($_POST["functions"] == "callRekundigeoperator"){
			if ($_POST["operator"] == "Toets"){
				$_SESSION["numbers"] = range(1,20);
				$_SESSION["operator"] = $_POST["operator"];
				$indexChecker = indexChecker(1);
				$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], rekundigeOperator($_SESSION["operator"]));
				echo $_SESSION["opdracht"][0];	
			}
			else {
			if ( isset($_SESSION["operator"])&& !empty($_SESSION["operator"]) ){
					$_SESSION["oldOperator"] = $_SESSION["operator"];
				}
				$_SESSION["operator"] = $_POST["operator"];
				$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], rekundigeOperator($_SESSION["operator"]));
				echo $_SESSION["opdracht"][0];				
			}
		}
		elseif ($_POST["functions"] == "callAssignmentindexCheckerandGenerator") {
			if (isset($_SESSION["oldOperator"]) && $_SESSION["oldOperator"] != $_SESSION["operator"]){
				$_SESSION["numbers"] = range(1,20);
			}
			else {
				$_SESSION["numbers"] = range(1,20);
			}
			$indexChecker = indexChecker($_POST["index"]);	
			$newOperator = rekundigeOperator($_SESSION["operator"]);
			if ($indexChecker == "eSave"){
				echo $indexChecker;
			}
			else {
				$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], $newOperator);
				echo $_SESSION["opdracht"][0];
			}
		}
		elseif ($_POST["functions"] == "callControlsaveAndassignmentGenerator"){
			$timeStop = time();
			$index = $_SESSION["index"] ;
			$antwoord = $_POST["antwoord"];
			$operator = $_SESSION["operator"];
			$som = $_SESSION["opdracht"][0];
			$uitkomst = $_SESSION["opdracht"][1];
			$timestart = $_SESSION["opdracht"][2];
			$timeDifference = $timeStop - $timestart;
			$opdrachtControlle = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan = opdrachtOpslaan($operator, $index , $som, $uitkomst, $antwoord, $opdrachtControlle[1], date("i:s",$timeDifference));
			$newOperator = rekundigeOperator($_SESSION["operator"]);
			$indexChecker = indexChecker("");
			if ($indexChecker == "eNumber"){
				echo $indexChecker;
			}
			else {
				$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], $newOperator);
				echo $_SESSION["opdracht"][0];
			}
		}
		elseif ($_POST["functions"] == "results") {
			$operator = $_SESSION["operator"];
			echo "<table>
					<tr>
						<td> $operator </td>
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
	// Global Section 1 - END
	// Global Section 2 - Login System
	function loginSystem($username){
		session_destroy();
		$_SESSION["username"] = $username;
		return $username;
	}
	// Global Section 2 -  END 

	// Global Section 3 - Assignment generator
	function rekundigeOperator($userSelection){
		// Section 1 - Operator Picker
		$operator = array("+", "-", "*", "");
		if ($userSelection == "+") {
			return $operator[0];
		}
		elseif ($userSelection == "-") {
			return $operator[1];
		}
		elseif ($userSelection == "*") {
			return $operator[2];
		}
		elseif ($userSelection == "/") {
			return $operator[3];
		}
		else {
			return $operator[mt_rand(0,3)];			
		}
	}
	function opdrachtGenerator($niveau, $rekundigeoperator) {
		// Section 1 - Number Generator
		if ($niveau == 4){
			$max = 10;
		}
		elseif ($niveau == 5) {
			$max = 20;
		}
		elseif ($niveau == 6) {
			$max = 100;
		}
		else {
			return false;
		}
		$min = 0;
		$getal1 = mt_rand($min, $max);
		$getal2 = mt_rand($min, $max);
		// End Section 1 - Number Generator
		
		// Section 2 - Operator Picker
		if ($rekundigeoperator == "+") {
			$uitkomst = $getal1 + $getal2;
			$som = "$getal1 + $getal2";
		}
		elseif ($rekundigeoperator == "-") {
			if ($getal1 < $getal2) {
				$tmpgetal = $getal1;
				$getal1 = $getal2;
				$getal2 = $tmpgetal;
			}
			$uitkomst = $getal1 - $getal2;
			$som = "$getal1 - $getal2";	
		}
		elseif ($rekundigeoperator == "*") {
			$uitkomst = $getal1 * $getal2;
			$som = "$getal1 x $getal2";
		}
		else {
			$min = 1;
			$getal1 = mt_rand($min, $max);
			$getal2 = mt_rand($min, $max);			
			while (!is_int($getal1/$getal2)){
				$getal1 = mt_rand($min, $max);
				$getal2 = mt_rand($min, $max);
			}
			$uitkomst = $getal1 / $getal2;
			$som = "$getal1 : $getal2";
		}
		// End Section 2 - Operator Picker
		$somUitkomstGetallen = array ($som, $uitkomst, time());
		return $somUitkomstGetallen;
	}
	// Global Section 3 - END
	// Global Section 4 - Index Comparison
	function indexComparison($index){
		if (empty($_SESSION["index"])){
			return true;
		}
		elseif (!empty($_SESSION["opdrachtOpslaan"][$_SESSION["operator"]][$index])) {
			return false;
		}
		else {
			return true;
		}
	}
	// Global Section 4 - END
	// Global Section 5 - Index Checker
	function indexChecker($index){
		$indexComparison = indexComparison($index);
		if ($indexComparison == true){
			if (!empty($_SESSION["numbers"])){
				if (!empty($index)) {		
						$_SESSION["index"] = $index;
				}
				else {
					if ($_SESSION["index"] == 20 && empty($_SESSION["operator"])){
						$_SESSION["index"] = 1;
					}
					else {
						$_SESSION["index"]++;
						while (!in_array($_SESSION["index"], $_SESSION["numbers"])) {
							$_SESSION["index"]++;
						}
					}
					if(($key = array_search($_SESSION["index"], $_SESSION["numbers"])) !== false) {
						unset($_SESSION["numbers"][$key]);
					}					
				}
			}
			else {
				return "eNumber"; // Empty Number
			}			
		}
		else {
			return "eSave"; // Empty Save;
		}
	}
	// Global Section 5 - END
	// Global Section 6 - Save Assignment
	function opdrachtOpslaan($operator, $index, $opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer) {
		$_SESSION["opdrachtOpslaan"][$operator][$index] = array($opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
		if (count($_SESSION["opdrachtOpslaan"][$operator]) == 20) {
			ksort ($_SESSION["opdrachtOpslaan"][$operator]);
		}
		return array($operator, $index, $opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
	}
	// Global Section 6 - END
	
	// Global Section 7 - Assignment Checker
	function opdrachtControleren($antwoord, $uitkomst){
		if ($antwoord == $uitkomst){
			return array(true, "goed");
		}
		else {
			return array(false, "fout");
		}
	}
	// Global Section 7 - END
?>