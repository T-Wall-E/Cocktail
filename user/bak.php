<?php
	include_once "functions.php";

	echo "<h2>Blutalkoholkonzentration</h2>";
	echo "<p>[!!!DISCLAIMER!!!]Alkohol ist böse</p>";
	
	// Cocktails der letzten 24h
	$arrOfCID = array();
	$sqlLastCocktails = "SELECT cid FROM history WHERE uid = " . $userArray['id'] . " AND TIMESTAMP >= DATE_SUB( CURDATE( ) , INTERVAL 1 DAY )";
	$sqlResultLastCocktails = mysql_query($sqlLastCocktails);
	if (!$sqlResultLastCocktails) {
		die('Ungültige Anfrage: ' . $sqlLastCocktails . mysql_error());
	}
	while($row = mysql_fetch_assoc($sqlResultLastCocktails))
	{
		$arrOfCID[] = $row['cid'];
	}
	
	// Reduktions-Faktor
	$reduFactor = 7;
	if($userArray['gender'])
	{
		$reduFactor = 6;
	}
	$reduFactor += $userArray['constitution'];
	$reduFactor /= 10;
	
	$eleminationfactor = 0.1;
	$hours = 0;
	
	echo "<h3>".number_format(calcBak($arrOfCID, $userArray["weight"], $reduFactor, $eleminationfactor, $hours), 3, ",", ".") . "&permil;</h3>";
	
	$table = "<table>";
	$table .= "<th>";
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "Promille";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Auswirkungen";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "0,0 - 0,2";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Keine oder wenige Auswirkungen";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "0,2 - 0,5";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Entspannung, \"gute Stimmung\", Wohlgef&uuml;hl";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "0,5 - 1.0";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Euphorisierung, leichte Beeintr&auml;chtigungen von Koordinations-, Reaktions- und Sehverm&ouml;gen";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "1,0 - 2,0";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Rauschzustand mit erheblichen Beeintr&auml;chtigungen im Koordinations-, Reaktions- und Sehverm&ouml;gen, Enthemmung und pl&ouml;tzliche Stimmungsschwankungen";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "2,0 - 3,0";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Bet&auml;ubungsstadium mit weiter minimiertem Reaktionsverm&ouml;gen und Verst&uml;rkung der Beeintr&auml;chtigungen";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "3,0 - 5,0";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "L&auml;hmungsstadium: Bewusstlosigkeit und Koma";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "<tr>";
	$table .= "<td>";
	$table .= "&gt; 5,0";
	$table .= "</td>";
	$table .= "<td>";
	$table .= "Ateml&auml;hmung, ist im schlimmsten Fall t&ouml;dlich ";
	$table .= "</td>";
	$table .= "</tr>";
	
	$table .= "</th>";
	$table .= "</table>";

	echo $table;
?>