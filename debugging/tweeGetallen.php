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
			if ($getal1 == 0){
				$getal1 = mt_rand($min, $max);
			}
			$uitkomst = $getal1 / $getal2;
				while (!is_int($uitkomst)){
						$getal1 = mt_rand($min, $max);
						$getal2 = mt_rand($min, $max);
						$uitkomst = $getal1 / $getal2;

				}
						$uitkomst = $getal1 / $getal2;
				$som = "$getal1 : $getal2";
		}
		$somEnuitkomst = array ($som, $uitkomst);
		return $somEnuitkomst;
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