<?php
	session_start();
		$gebruikerSelectie = "/";
		$operator = rekundigeOperator($gebruikerSelectie);
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
			$_SESSION["operator"] = $_POST["operator"];
			$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], rekundigeOperator($_SESSION["operator"]));
			echo $_SESSION["opdracht"][0];
			
		}
		elseif ($_POST["functions"] == "callAssignmentindexCheckerandGenerator") {
			//echo json_encode(assignmentIndexcheckerAndGenerator($_POST["index"], $_SESSION["operator"]));
			$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], $_SESSION["operator"]);
			echo $_SESSION["opdracht"][0];
		}
		elseif ($_POST["functions"] == "callControlsaveAndassignmentGenerator"){
			$timeStop = time();
			$index = end($_SESSION["index"]) ;
			$antwoord = $_POST["antwoord"];
			$operator = $_SESSION["operator"];
			$som = $_SESSION["opdracht"][0];
			$uitkomst = $_SESSION["opdracht"][1];
			$timestart = $_SESSION["opdracht"][2];
			$timeDifference = $timeStop - $timestart;
			$opdrachtControlle = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan = opdrachtOpslaan($operator, $index , $som, $uitkomst, $antwoord, $opdrachtControlle[1], date("i:s",$timeDifference));
			$newOperator = rekundigeOperator($_SESSION["operator"]);
			$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], $newOperator);
			$returnArray = array($_SESSION["opdracht"][0], assignmentIndexcheckerAndGenerator("") , allAssignmentChecker());
			echo json_encode($returnArray);
		}
		elseif ($_POST["functions"] == "results") {
			foreach ($_SESSION["opdrachtOpslaan"] as $key => $value) {
				echo "<tr> <td> $key</td>";
					foreach ($value as $key2 => $value2 ){
						echo "<td> $key2</td>";
						foreach ($value2 as $key3) {
							echo "<td> $key3 </td>";
						}
					}
				echo "</tr>";
			}
		}
	}
	// Global Section 2 - Login System
	function loginSystem($username){
		if (!empty($_SESSION["username"])){
			$_SESSION["username"] = $username;
		}
		else {
			unset($_SESSION);
			$_SESSION["username"] = $username;
		}
		return $username;
	}
	// End Global Section 2 - Login System

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
	function allAssignmentChecker() {
		return array_diff(range(1,20), $_SESSION["index"]);
	}
	// Global Section 4 - Assignment Index Checker
	function assignmentIndexcheckerAndGenerator($index) {
			if (!empty($_SESSION["index"]) && empty($index)){
				$_SESSION["counter"]++;
			}
			else {
				$_SESSION["index"] = array($index - 1 => $index);
				$_SESSION["counter"] = $index;
			}

	}
	// Global Section 4 - END
	// Global Section 4 - Save Assignment
	function opdrachtOpslaan($operator, $index, $opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer) {
		if ($index == 1){
			$_SESSION["opdrachtOpslaan"][$operator][$index] = array($opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
		}
		else {
			$_SESSION["opdrachtOpslaan"][$operator][$index] = array($opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
		}
	}
	// Global End Section 4
	
	// Global Section 5 - Assignment Checker
	function opdrachtControleren($antwoord, $uitkomst){
		if ($antwoord == $uitkomst){
			return array(true, "goed");
		}
		else {
			return array(false, "fout");
		}
	}
	// Global End Section 5
	// Global Section 6
?>