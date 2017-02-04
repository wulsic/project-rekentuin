<?php
	// Global Section 1 - Login System
	function loginSystem($username){
		session_destroy();
		session_start();
		$_SESSION["username"] = $username;
		return $username;
	}
	// Global Section 1 -  END

	// Global Section 2 - Assignment generator
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
	// Global Section 2 - END
	function AssignmentindexCheckerandGenerator($index){
			if (isset($_SESSION["oldOperator"]) && $_SESSION["oldOperator"] != $_SESSION["operator"] || empty($_SESSION["numbers"])){
				$_SESSION["numbers"] = range(1,20);
			}
			$indexChecker = indexChecker($index);	
			$newOperator = rekundigeOperator($_SESSION["operator"]);
			$_SESSION["opdracht"] = opdrachtGenerator($_SESSION["group"], $newOperator);
			return $_SESSION["opdracht"][0];	
	}
	// Global Section 3 - Index Checker
	function indexChecker($index){
		if (!empty($index)) {		
			$_SESSION["index"] = (int)$index;
		}
		else {
			unset($_SESSION["numbers"][$_SESSION["index"] - 1]);
			if (!empty($_SESSION["numbers"])){
				if ($_SESSION["index"] == 20){
					$_SESSION["index"] = 1;
				}
				else {
					$_SESSION["index"]++;
					$_SESSION["debug"] = $_SESSION["index"];	
					while (!array_search($_SESSION["index"], $_SESSION["numbers"])) {
						$_SESSION["index"]++;
					}
				}
			}
			else {
				return "eNumber"; // Empty Number
			}
		}
	}
	// Global Section 3 - END
	
	// Global Section 4 - Save Assignment
	function opdrachtOpslaan($operator, $index, $opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer) {
		$_SESSION["opdrachtOpslaan"][$operator][$index] = array($opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
		if (count($_SESSION["opdrachtOpslaan"][$operator]) == 20) {
			ksort ($_SESSION["opdrachtOpslaan"][$operator]);
		}
	}
	// Global Section 4 - END
	
	// Global Section 5 - Assignment Checker
	function opdrachtControleren($antwoord, $uitkomst){
		if ($antwoord == $uitkomst){
			return "goed";
		}
		else {
			return "fout";
		}
	}
	// Global Section 5 - END
?>