<?php
include_once 'dbCon.php';

function getAllocation()
{
	$sql = "SELECT ingredient FROM `allocation`";
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	while($row = mysql_fetch_assoc($sqlResult))
	{
		$result[] = $row['ingredient'];
	}
	
	return $result;
}

function allIngredientsAvailable($cocktailID)
{
	$result = true;
	$allocation = getAllocation();
	
	$sql = "SELECT ingredients.id as Ingredient "
							. "FROM Recipes "
							. "INNER JOIN cocktails "
							. "ON cocktails.ID = Recipes.CID "
							. "INNER JOIN ingredients "
							. "ON ingredients.ID = Recipes.IID "
							. "WHERE cocktails.id = " . $cocktailID;
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	while($row = mysql_fetch_assoc($sqlResult))
	{
		if(!in_array($row['Ingredient'], $allocation))
			$result = false;
	}
	return $result;
}
?>