<?php
/*
#	Author: Tobias Wallewein
#
#	Eine �bersicht �ber alle Cocktails
#	mit Kennzeichnung, ob mit aktueller
#	"Bef�llung" (s. allocation.php) m�glich
*/
include_once 'dbCon.php';
include_once 'functions.php';

//########### Funktionen ###############


function getCocktails()
{
	$result = "";
	
	$sql = "SELECT *  FROM `cocktails`";
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ung�ltige Anfrage: ' . $sql . ' - Gesamte Abfrage: '. mysql_error());
	}
	
	$result .= "<table border='1'>";
	//$result .= "<tr>";
	$result .= "<th>";
	$result .= "Cocktail";
	$result .= "</th>";
	$result .= "<th>";
	$result .= "Verf�gbar?";
	$result .= "</th>";
	//$result .= "</tr>";
	
	while($row = mysql_fetch_assoc($sqlResult))
	{
		$result .= "<tr>";
		$result .= "<td>";
		$result .= "<a href=cocktail.php?id=" . $row['ID'] . ">" . $row['Name'] . "</a>";
		$result .= "</td>";
		$result .= "<td>";
		$result .= allIngredientsAvailable($row['ID']) ? "JA" : "NEIN";
		$result .= "</td>";
		$result .= "</tr>";
	}
	
	$result .= "</table>";
	
	return $result;
}


//########### End of Funktionen ###############

	echo getCocktails();
 ?>
