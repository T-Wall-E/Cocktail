<?php
/*
#	Author: Tobias Wallewein
#
#	�bersicht �ber den gew�hlten Cocktail
#	Wenn alle Zutaten verf�gbar (s. allocation.php),
#	dann kann der Prozess zum Erstellen des Cocktails gestartet werden.
*/

include_once "dbCon.php";
include_once "functions.php";

// ########### Function ##################

function getCocktail($id)
{
	$result = "";
	
	$sqlCocktail = "SELECT *  FROM `cocktails` WHERE `ID` = " . $id;
	$sqlCocktailResult = mysql_query($sqlCocktail);
	if (!$sqlCocktailResult) {
		die('Ung�ltige Anfrage: ' . $sqlCocktail . mysql_error());
	}
	
	$row = mysql_fetch_assoc($sqlCocktailResult);
	$result .= "<h1>" . $row['Name'] . "</h1>";
	$result .= "<img src=". $row['ImageURL']. " alt=" . $row['ImageURL'] . " />";
	$result .= "<p>" . $row['Description'] . "</p>";
	
	$sqlReceipe = "SELECT ingredients.name as Ingredient, units.name as Unit, units.token as UnitToken, amount "
							. "FROM Recipes "
							. "INNER JOIN cocktails "
							. "ON cocktails.ID = Recipes.CID "
							. "INNER JOIN ingredients "
							. "ON ingredients.ID = Recipes.IID "
							. "INNER JOIN units "
							. "ON ingredients.UID = units.ID "
							. "WHERE cocktails.id = " . $id;

	$sqlReceipeResult = mysql_query($sqlReceipe);
	if (!$sqlReceipeResult) {
		die('Ung�ltige Anfrage: ' . $sqlReceipe . mysql_error());
	}
							
	$result .= "<h3>Zutaten</h3>";
	$result .= "<ul>";
	while($row = mysql_fetch_assoc($sqlReceipeResult))
	{
		$result .= "<li>";
		$result .= $row['Ingredient'] . " " . $row['amount'] . $row['UnitToken'];
		$result .= "</li>";
	}
	$result .= "</ul>";
		
	echo $result;
}

// ########### End of Function ###########

  if(isset($_GET["id"]))
  {
	getCocktail(htmlspecialchars($_GET["id"]));
	if(allIngredientsAvailable($_GET["id"]))
	{
		echo "<form action='queue.php' method='post'>";
		echo "<input type='hidden' name='cocktailID' value='" . $_GET["id"] . "'/>";
		echo "<input type='submit' value='Mix mir diesen Cocktail!'/>";
		echo "</form>";
	}
  }
  else
  {
	echo "Mit dieser ID existiert kein Cocktail...";
  }
  ?>
