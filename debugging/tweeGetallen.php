<?php
	session_start();
		$gebruikerSelectie = "/";
		$operator = rekundigeOperator($gebruikerSelectie);
	// Global Section 1 - Ajax
	if (isset($_POST["functions"]))  {
		if ($_POST["functions"] == "gebruikersNaam"){
			$_SESSION["gebruikersNaam"] = $_POST["gebruikersNaam"];
			echo $_SESSION["gebruikersNaam"];
		}
		elseif ($_POST["functions"] == "opdrachtGenerator") {
			for ($a = 1; $a < 21; $a++){
				$_SESSION["opdracht"][$a] = opdrachtGenerator($_POST["groep"], $_POST["operator"]);
			}
		}
		elseif ($_POST["functions"] == "opdrachtSelectie"){
			echo $_SESSION["opdracht"][$_POST["indexNumber"]][0];
		}
		elseif ($_POST["functions"] == "antwoord"){
			$timeStop = time();
			$index = $_POST["indexNumber"];
			$index = $_POST["indexNumber"];
			$antwoord = $_POST["antwoord"];
			$operator = $_POST["operator"];
			$som = $_SESSION["opdracht"][$_POST["indexNumber"]][0];
			$uitkomst = $_SESSION["opdracht"][$_POST["indexNumber"]][1];
			$timestart = $_SESSION["opdracht"][$_POST["indexNumber"]][2];
			$timeDifference = $timeStop - $timestart;
			$opdrachtControlle = opdrachtControleren($antwoord, $uitkomst);
			$opdrachtOpslaan = opdrachtOpslaan($operator, $index , $som, $uitkomst, $opdrachtControlle[1], $timeDifference);
			$returnArray = array($som, $opdrachtControlle[0], $_SESSION["opdrachtOpslaan"]);
			echo json_encode($returnArray);
		}
		elseif ($_POST["functions"] == "results") {
			echo json_encode($_SESSION["opdrachtOpslaan"]);
		}
	}
	// End Global Section 1 - Login System

	// Global Section 2 - Assignment generator
	function rekundigeOperator($gebruikerSelectie){
		$operator = array("+", "-", "x", "");
		if ($gebruikerSelectie == "+") {
			return $operator[0];
		}
		elseif ($gebruikerSelectie == "-") {
			return $operator[1];
		}
		elseif ($gebruikerSelectie == "x") {
			return $operator[2];
		}
		elseif ($gebruikerSelectie == "/") {
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
		elseif ($rekundigeoperator == "x") {
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
	// Global End Section 2 - Opdracht Generator
	// Section 3 - Save Assignment
	function opdrachtOpslaan($operator, $counter, $opdracht, $uitkomst, $opdrachtGoedofFout, $opdrachtTimer) {
		if ($counter == 1){
			$_SESSION["opdrachtOpslaan"][$operator][$counter] = array($opdracht, $uitkomst, $opdrachtGoedofFout, $opdrachtTimer);
		}
		else {
			$_SESSION["opdrachtOpslaan"][$operator][$counter] = array($opdracht, $uitkomst, $opdrachtGoedofFout, $opdrachtTimer);
		}
	}
	// End Section 3
	//Section 3 - Assignment Checker
	function opdrachtControleren($antwoord, $uitkomst){
		if ($antwoord == $uitkomst){
			return array(true, "goed");
		}
		else {
			return array(false, "fout");
		}
	}
?>