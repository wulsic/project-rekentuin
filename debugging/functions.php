<?php
	// Section 1 - Login System
	function loginSystem($username){
		session_destroy();
		session_start();
		$_SESSION["username"] = $username;
		return $username;
	}
	// Section 1 -  END
	
	// Section 2 - Delete Assignments
	function deleteAssignments($variable){
		$index 	  = $_SESSION["index"];
		$group	  = $_SESSION["group"];
		$operator = $_SESSION["operator"];
		
			if ($variable != "Opnieuw beginnen"){
				if ($operator != "Toets"){
					unset($_SESSION["opdrachtOpslaan"][$operator][$_POST["index"]]);
					$_SESSION["index"] = $_POST["index"];
				}
				else {
					unset($_SESSION["opdrachtOpslaan"][$operator]);
				}
				$_SESSION["opdracht"] = opdrachtGenerator($group, rekundigeOperator($operator));
				return $_SESSION["opdracht"][0];
			}
			else {
				unset($_SESSION["opdrachtOpslaan"][$operator]);
			}
			$_SESSION["numbers"] = range(1,20);
	}
	// Section 2 - END

	// Section 3 - Assignment generator
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
		// Section 3.2 - Number Generator
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
		
		// Section 3.3 - Operator Picker
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
	// Section 3 - END
	
	// Section 4 - Assign index and call the generator for the first assignment
	function indexCheckerandGenerator($index){
		// Section 4.1 - Error Response
		if (isset($_SESSION["operator"])){
			
			// Section 4.1.1 - Put all sessions into a more readable variable
			$group			 = $_SESSION["group"];
			$operator 		 = $_SESSION["operator"];
			
			// Section 4.1.2 - Check for already made assignments
			if (empty($_SESSION["opdrachtOpslaan"][$operator][$index]) || $operator == "Toets"){
				
				
				// Section 4.1.2-1 - Set session numbers if numbers is empty or the old operator is not the same as the current one.
				if (isset($_SESSION["oldOperator"]) && $_SESSION["oldOperator"] != $operator || empty($_SESSION["numbers"])){
					$_SESSION["numbers"] = range(1,20);
				}
				
				// Section 4.1.2-2 - Call functions
				$indexChecker = indexChecker($index);
				$_SESSION["opdracht"] = opdrachtGenerator($group, rekundigeOperator($operator));
				return $_SESSION["opdracht"][0];	
			}
			// Section 4.1.3 - Return array for a popup when the assignment is already made.
			else {
				
				// Section 4.1.3-1 - Put all sessions into a more readable variable
				$assignment	= $_SESSION["opdrachtOpslaan"][$operator][$index][0];
				$outcome	= $_SESSION["opdrachtOpslaan"][$operator][$index][2];
				$answer		= $_SESSION["opdrachtOpslaan"][$operator][$index][3];
				
				$text = "<p> Je hebt deze som al gemaakt </p>
						<p> Het som was: </p>
						<p> {$assignment} = {$outcome} </p>
						<p> Jouw antwoord was: </p>
						<p> {$answer} </p>
						<p> wil je deze som opnieuw maken? </p>";
						
				return array("popup", $text);
			}
		}
		else {
			return "operator not set";
		}
	}
	// Section 4 - END
	
	// Section 5 - Index Checker
	function indexChecker($index){
		
		// Section 5.1 - Set session index
		if (!empty($index)) {
			$_SESSION["index"] = (int)$index;
		}
		else {
			
			// Section 5.1.1 - Remove a number and then check whether session numbers is empty
			unset($_SESSION["numbers"][$_SESSION["index"] - 1]);
			if (!empty($_SESSION["numbers"])){
				
				// Section 5.1.1-1 - Set session index 1 when it hits 20. If it' not 20 it will up the number currently in session index.
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
	// Section 5 - END
	
	// Section 6 - Save Assignment
	function opdrachtOpslaan($operator, $index, $opdracht, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer) {
		$gelijkteken = "=";
		$_SESSION["opdrachtOpslaan"][$operator][$index] = array($opdracht, $gelijkteken, $uitkomst, $antwoord, $opdrachtGoedofFout, $opdrachtTimer);
	}
	// Section 6 - END
	
	// Section 7 - Assignment Checker
	function opdrachtControleren($antwoord, $uitkomst){
		if ($antwoord == $uitkomst){
			return "goed";
		}
		else {
			return "fout";
		}
	}
	function cijferBerekenen(){
		$operator 		 = $_SESSION["operator"];
		$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
		//Array keys search all keys, array column sends back single column of input. That input is 4, because at index 4 there lies the value we need: "fout" or "goed". Array column return that value as an array([0] = "fout/goed").
		//Array keys then search that returned array for "fout" and return an array with the key as value(array([0] = 1)). Using count, it count's how many keys are in the returned array from array keys.
		//Array Keys: http://php.net/manual/en/function.array-keys.php | Array Column: http://php.net/manual/en/function.array-column.php . Refer to debug.php for testing these 2 functions if you still don't understand.
		$fout = count(array_keys(array_column($opdrachtOpslaan[$operator], 4), "fout")); // Source: http://www.php.net/manual/en/function.array-search.php#106904 at User Contributed Notes: user xfoxawy
		$goed = count(array_keys(array_column($opdrachtOpslaan[$operator], 4), "goed"));
		$CountedAssignments = $fout + $goed;
		$c = 10 - ($fout * 0.5); //Var C is Het cijfer
		if ($CountedAssignments == 20){
			if ($c == 10){
				$reactie = "School heeft geen zin meer voor jou.";
			}
			elseif ($c >= 8 && $c < 10){
				$reactie = "Wauw! Dat heb je goed gemaakt!";
			}
			elseif ($c >= 6 && $c < 8){
				$reactie = "Goed gedaan!";
			}
			elseif ($c >= 5.5 && $c < 6){
				$reactie = "Je deed het goed maar nog een beetje bij spijkeren";
			}
			elseif ($c >= 4 && $c < 5.5){
				$reactie = "Net niet goed, jammer. Blijf oefenen";
			}
			elseif ($c >= 0 && $c < 4){
				$reactie = "Maak de oefeningen goed overnieuw en probeer nogmaals";
			}
		}
		else {
			$reactie = "De sommen zijn nog niet afgemaakt"; 
		}
		return array('reactie' => $reactie, 'fouten' => $fout);
	}
	// Section 7 - END
	
	// Section 8 - Test Page
	function oefenToets(){
		$operator = $_SESSION["operator"];
		if (isset($_SESSION["opdrachtOpslaan"][$operator])){
			if (count($_SESSION["opdrachtOpslaan"][$operator]) == 20){
				if (empty($_SESSION["opdrachtOpslaan"][$operator]) && isset($_SESSION["number"])){
					return array("popup", "operator");
				}
				else {
					$_SESSION["operator"] = "Oefentoets";
					return indexCheckerandGenerator(1);
				}
			}
			else {
				return "popup";
			}
		}
		else {
			return "popup";
		}		
	}
	function testPage(){// Test is such a pain in the frigin ass.
		$text = array("popup", "<p> Je hebt deze toets al gemaakt </p> <p> wil je deze toets opnieuw maken? </p>");
		$operator = $_SESSION["operator"];
		if (isset($_SESSION["opdrachtOpslaan"][$operator])){
			if (count($_SESSION["opdrachtOpslaan"][$operator]) != 20){
				if (empty($_SESSION["opdrachtOpslaan"][$operator]) && isset($_SESSION["number"])){
					return $text;
				}
				else {
					return indexCheckerandGenerator(1);
				}
			}
			else {
				return $text;
			}
		}
		else {
				return indexCheckerandGenerator(1);	
		}
	}
	// Section 8 - END
	
	// Section 8 - Result page
	function resultPage(){
		$operator = $_SESSION["operator"];
		$cijferEnFouten = cijferBerekenen();
		$reactie = $cijferEnFouten['reactie'];
		$aantalFouten = $cijferEnFouten['fouten'];
		
		if (empty($_SESSION["opdrachtOpslaan"][$operator])){
			$table = "<p> Je hebt geen 1 van de vragen beantwoord. </p>";
		}
		else {
			$opdrachtOpslaan = $_SESSION["opdrachtOpslaan"];
			ksort ($opdrachtOpslaan[$operator]);
				$table = "<table>
						<tr>
							<td> $operator </td>
							<td> Aantal fouten: $aantalFouten</td>
							<td> $reactie </td>
						</tr>
						<tr>
							<td> Opdracht </td>
							<td style='padding-right:20px;'> Som </td>
							<td style='padding-right:20px;'> </td>
							<td> Uitkomst </td>
							<td> Jouw Antwoord </td>
							<td> Goed of Fout </td>
							<td> Jouw tijd</td>
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
		}
		return $table;			
	}
	// Section 8 - END
?>