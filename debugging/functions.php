<?php
	// Section 1 - Login System
	function loginSystem($username){
		session_destroy();
		session_start();
		$_SESSION["username"] = $username;
		return $username;
	}
	// Section 1 -  END

	// Section 2 - Assignment generator
	function rekundigeOperator($userSelection){
		// Section 2.1 - Operator Picker
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
		// Section 2.2 - Number Generator
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
		
		// Section 2.3 - Operator Picker
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
		$somUitkomstGetallen = array ($som, $uitkomst, time());
		return $somUitkomstGetallen;
	}
	// Section 2 - END
	
	// Section 3 - Assign index and call the generator for the first assignment
	function indexCheckerandGenerator($index){
		// Section 3.1 - Error Response
		if (isset($_SESSION["operator"])){
			
			// Section 3.1.1 - Put all sessions into a more readable variable
			$group			 = $_SESSION["group"]
			$operator 		 = $_SESSION["operator"];
			$oldOperator	 = $_SESSION["oldOperator"];
			$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
			
			// Section 3.1.2 - Check for already made assignments
			if (empty($opdrachtOpslaan[$operator][$index])){
				
				// Section 3.1.2-1 - Set session numbers if numbers is empty or the old operator is not the same as the current one.
				if ($oldOperator != $operator || empty($_SESSION["numbers"])){
					$_SESSION["numbers"] = range(1,20);
				}
				
				// Section 3.1.2-2 - Call functions
				$indexChecker = indexChecker($index);	
				$_SESSION["opdracht"] = opdrachtGenerator($group, rekundigeOperator($operator));
				$whatToreturn = $_SESSION["opdracht"][0];
				
			}
			else {
				// Section 3.1.2-3 - Return array for a popup when the assignment is already made.
				$whatToreturn = array("true", $opdrachtOpslaan[$operator][$index]);
			}
			return $whatToreturn;
		}
		else {
			return "operator not set";
		}
	}
	// Section 3 - END
	
	// Section 4 - Index Checker
	function indexChecker($index){
		
		// Section 4.1 - Set session index
		if (!empty($index)) {
			$_SESSION["index"] = (int)$index;
		}
		else {
			
			// Section 4.1.1 - Remove a number and then check whether session numbers is empty
			unset($_SESSION["numbers"][$_SESSION["index"] - 1]);
			if (!empty($_SESSION["numbers"])){
				
				// Section 4.1.1-1 - Set session index 1 when it hits 20. If it' not 20 it will up the number currently in session index.
				if ($_SESSION["index"] == 20){
					$_SESSION["index"] = 1;
				}
				else {
					$_SESSION["index"]++;
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
	// Section 4 - END
	
	// Section 5 - Save Assignment
	function opdrachtOpslaan($operator, $index, $opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer) {
		$gelijkteken = "=";
		$_SESSION["opdrachtOpslaan"][$operator][$index] = array($opdracht, $gelijkteken, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
		if (count($_SESSION["opdrachtOpslaan"][$operator]) == 20) {
			ksort ($_SESSION["opdrachtOpslaan"][$operator]);
		}
	}
	// Section 5 - END
	
	// Section 6 - Assignment Checker
	function opdrachtControleren($antwoord, $uitkomst){
		if ($antwoord == $uitkomst){
			return "goed";
		}
		else {
			return "fout";
		}
	}
	// Section 6 - END
	
	// Section 7 - Result page
	function resultPage(){
		$operator 		 = $_SESSION["operator"];
		$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
			$table = "<table>
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
		foreach ($opdrachtOpslaan[$operator] as $key => $value) {
		$table 	.= "<tr>
						<td> $key</td>";
		foreach ($value as $key2) {
			  $table .= "<td> $key2 </td>";
		}
		$table  .= "</tr>";
		}
		$table .= "</table>";
		return $table;
	}
	// Section 7 - END
?>