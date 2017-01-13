<?php
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
		elseif ($gebruikerSelectie == ":") {
			return $operator[3];
		}
		else {
			return $operator[mt_rand(0,3)];
		}
	}

	function sommenGenerator($niveau, $rekundigeoperator) {
		if ($niveau == 4){
			$max = 10;
		}
		elseif ($niveau == 5) {
			$max = 20;
		}
		else {
			$max = 100;
		}
		$min = 0;
		$getalrange = array(
		"getal1" => range($min, $max),
		"getal2" => range($min, $max)
		);
		$getal1 = mt_rand($min, $max);
		$getal2 = mt_rand($min, $max);
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
			$divisionarray = divisionOperator($getal1, $getal2);
			print_r($divisionarray);
			$getal1 = $divisionarray[0];
			$getal2 = $divisionarray[1];
			$som = "$getal1 : $getal2";
			$uitkomst = $getal1 / $getal2;
		}
		$somEnuitkomst = array ($som, $uitkomst);
		return $somEnuitkomst;
	}

	function divisionOperator ($getal1, $getal2) {
	if ($getal1 < $getal2){
		$temp = $getal2; //Wissel getal1 en getal2 van plek
		$getal2 = $getal1;
		$getal1 = $temp;
	}
//	if ($getal1 % $getal2 !== 0){ //Check of er een heel getal uitkomt
		$counter = 0;
		for ($x=1;$x<=$getal1;$x++){
			$divisioncheck = $getal1 / $x;
			if (is_int($divisioncheck) == true){ //Check of er een integer uitkomt
				$divisionarray[$counter] = $divisioncheck;
				$counter++;
			}
		}
		return array($getal1, $divisionarray[rand(1, $counter -1)]); //Fix offset met counter -1;
//	}
	/*else{
		return array($getal1, $getal2);
	}*/
}

?>
<pre>
	<?php
		$gebruikerSelectie = ":";
		$operator = rekundigeOperator($gebruikerSelectie);
		echo "<br/>";
		print_r(sommenGenerator(6 , $operator));
	?>
</pre>
