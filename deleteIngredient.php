<?php
	session_start();
	include_once "dbCon.php";
	
	if(isset($_SESSION['GID']))
	{
		switch($_SESSION['GID'])
		{
			case 1:
			case 2:
				if(isset($_GET['id']))
				{
					// �berpr�fen ob diese Zutat noch von Cocktails verwendet wird?
					
					$sqlCount = "SELECT * FROM `recipes` WHERE IID=" . mysql_real_escape_string ($_GET['id']);
					$resultCount = mysql_query($sqlCount);
					$count = -1;
					
					if($resultCount)
					{
						$count = mysql_num_rows($resultCount);
					}
					
					if($count > 0)
					{
						$error = "Zutat wird noch von ";
						$error .= $count == 1 ? "einem Cocktail" : $count . " Cocktails ";
						$error .= "verwendet und wurde deshalb nicht gel�scht!";
						$_SESSION['error'] = $error;
						
						break;
					}
					
					// L�schen
					$sqlDelete = "DELETE FROM `ingredients` WHERE ID=" . mysql_real_escape_string ($_GET['id']);
					$resultDelete = mysql_query($sqlDelete);
					
					if($resultDelete)
					{
						$_SESSION['success'] = "Zutat wurde gel�scht";
					}
					else
					{
						$_SESSION['error'] = "Fehler beim L�schen";
					}
					
				}
				break;		
		}
	}
	
	
	header("location: ingredients.php");
?>