<?php
/*
#	Author: Tobias Wallewein
#
#	Übersicht über den gewählten Cocktail
#	Wenn alle Zutaten verfügbar (s. allocation.php),
#	dann kann der Prozess zum Erstellen des Cocktails gestartet werden.
*/

include_once "dbCon.php";
include_once "functions.php";

// ########### Function ##################

function getHTMLCocktail($id)
{
	$result = "";
	
	$sqlCocktail = "SELECT *  FROM `cocktails` WHERE `ID` = " . $id;
	$sqlCocktailResult = mysql_query($sqlCocktail);
	if (!$sqlCocktailResult) {
		die('Ungültige Anfrage: ' . $sqlCocktail . mysql_error());
	}
	
	$row = mysql_fetch_assoc($sqlCocktailResult);
	$result .= "<h1>" . $row['Name'] . "</h1>";
	$result .= "<img src=". $row['ImageURL']. " alt=" . $row['ImageURL'] . " />";
	if(isset($_SESSION['GID']))
	{
		switch($_SESSION['GID'])
		{
			case 1:
			case 2:
				$result .= '<p><a href="/Cocktail/editCocktail.php?id=' . $id . '" title="Cocktail bearbeiten" class="link">Cocktail bearbeiten</a></p>';
				break;		
		}
	}
	$result .= "<p>" . $row['Description'] . "</p>";
	
	$sqlReceipe = "SELECT ingredients.name as Ingredient, units.name as Unit, units.token as UnitToken, amount "
							. "FROM recipes "
							. "INNER JOIN cocktails "
							. "ON cocktails.ID = recipes.CID "
							. "INNER JOIN ingredients "
							. "ON ingredients.ID = recipes.IID "
							. "INNER JOIN units "
							. "ON ingredients.UID = units.ID "
							. "WHERE cocktails.id = " . $id;

	$sqlReceipeResult = mysql_query($sqlReceipe);
	if (!$sqlReceipeResult) {
		die('Ungültige Anfrage: ' . $sqlReceipe . mysql_error());
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
		
	return $result;
}

// ########### End of Function ###########

  if(isset($_GET["id"]))
  {
	echo getHTMLCocktail(mysql_real_escape_string ($_GET["id"]));
	
	if(allIngredientsAvailable($_GET["id"]))
	{
		$form = "<form action='queue.php' method='post'>";
		$form .= "<input type='hidden' name='cocktailID' value='" . htmlspecialchars($_GET["id"]) . "'/>";
		$form .= "<input type='hidden' name='redirect' value='cocktail.php?id=" . htmlspecialchars($_GET["id"]) . "'/>";
		$form .= "<input type='hidden' name='userID' value='";
		if(isset($_SESSION["UID"]))
		{
			$form .= htmlspecialchars($_SESSION["UID"]);
		}
		else
		{
			$form .= -1;
		}			
		$form .= "'/>";
		$form .= "<input type='submit' value='Mix mir diesen Cocktail!'/>";
		$form .= "</form>";
		
		echo $form;
	}
  }
  else
  {
	echo "Mit dieser ID existiert kein Cocktail...";
  }
  ?>