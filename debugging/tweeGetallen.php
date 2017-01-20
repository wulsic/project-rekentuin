<?php
	session_start();
	$counter = 1;
		$gebruikerSelectie = "/";
		$operator = rekundigeOperator($gebruikerSelectie);
	// Global Section 1 - Ajax

	if (isset($_POST["functions"]))  {
		if ($_POST["functions"] == "gebruikersNaam"){
			$_SESSION["gebruikersNaam"] = $_POST["gebruikersNaam"];
		}
		elseif ($_POST["functions"] == "opdrachtGenerator") {
			$opdracht = opdrachtGenerator($_POST["groep"], $_POST["operator"]);
			echo $opdracht[0];
		}
		elseif ($_POST["functions"] == "antwoord"){
			$timeStop = time();
			$timeDifference = $timeStop - $opdracht[2];
			$opdrachtControlle = opdrachtControleren($_POST["antwoord"], $opdracht[1]);
			$opdrachtOpslaan = opdrachtOpslaan($opdracht[0], $opdrachtControlle[1], $timeDifference);
			$testArray = array($opdrachtControlle, $opdrachtOpslaan);
			echo json_encode($testArray) . $opdrachtControlle[0] . $opdracht[0] . $opdracht[1] ;
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
	function opdrachtOpslaan($opdracht, $opdrachtGoedofFout, $opdrachtTimer) {
		return array($counter, $opdracht, $opdrachtGoedofFout, $opdrachtTimer);
		if ($counter == 1){
			
		}
		else {
			$counter++;
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