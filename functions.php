<?php
include_once 'dbCon.php';
include_once 'constants.php';

function isAdminBy_SESSION()
{
	$result = false;
	
	if(isset($_SESSION['GID']))
	{
		switch($_SESSION['GID'])
		{
			case 1:
			case 2:
				$result = true;
				break;		
		}
	}
	
	return $result;
}

function getIngredientsCombobox($preselectID = null)
{
  $sql = "SELECT i.ID, i.name, u.token FROM `ingredients` i JOIN units u ON i.UID = u.ID  ORDER BY name";
  $sqlresult = mysql_query($sql);
  if (!$sqlresult)
  {
     $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
     $message .= 'Gesamte Abfrage: ' . $sql;
     die($message);
  }

  $result = "";
  $result .= "<select name='ingredients[]' size='1'>";
  while ($row = mysql_fetch_array($sqlresult))
  {
	if($preselectID != null && $row['ID'] == $preselectID)
	{
		$result .=  "<option value='" . $row['ID'] . "' selected>";
	}
	else
	{
		$result .=  "<option value='" . $row['ID'] . "'>";
	}
    $result .= $row['name'] . " (" . $row['token'] . ")</option>";
  }
  $result .=  "</select>";
  return $result;
}

function getUnitsCombobox()
{
  $sql = "SELECT * FROM `units` ORDER BY token";
  $sqlresult = mysql_query($sql);
  if (!$sqlresult)
  {
     $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
     $message .= 'Gesamte Abfrage: ' . $sql;
     die($message);
  }

  $result = "";
  $result .= "<select name='units[]' size='1'>";
  while ($row = mysql_fetch_array($sqlresult))
  {
    $result .=  "<option value='" . $row['ID'] . "' ";
    $result .= ">" . $row['token'] . " (" . $row['name'] . ")" . "</option>";
  }
  $result .=  "</select>";
  return $result;
}

function getUser($userId)
{
	$sql = "SELECT id, user, name, lastname, user_group, ava, birthdate, gender FROM `users` WHERE id = ".$userId;
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	while($row = mysql_fetch_assoc($sqlResult))
	{
		return $row;
	}
	
	return false;
}

function getHistoryCount($userId)
{
	$sql = "SELECT * FROM `history` WHERE UID = " . $userId;
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	return mysql_num_rows($sqlResult);
}

function getHistory($userId)
{
	$sql = "SELECT c.name AS Cocktailname, c.id AS CocktailID, Timestamp FROM `history` h JOIN users u ON h.UID = u.id JOIN cocktails c ON h.CID = c.ID WHERE h.UID = " . $userId;
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	$table = "<table>";
	$table .= "<thead>";
	$table .= "<tr>";
	$table .= "<th>";
	$table .= "#";
	$table .= "</th>";
	$table .= "<th>";
	$table .= "Cocktail";
	$table .= "</th>";
	$table .= "<th>";
	$table .= "Datum";
	$table .= "</th>";
	$table .= "</tr>";
	$table .= "</thead>";
	$table .= "<tbody>";
	$count = 1;
	while($row = mysql_fetch_assoc($sqlResult))
	{
		$table .= "<tr>";
		$table .= "<td>";
		$table .= $count++;
		$table .= "</td>";
		$table .= "<td>";
		$table .= "<a href='cocktail.php?id=" .  $row["CocktailID"] . "' title='" . $row["Cocktailname"] . "'>" . $row["Cocktailname"] . "</a>";
		$table .= "</td>";
		$table .= "<td>";
		$table .= $row["Timestamp"];
		$table .= "</td>";
		$table .= "</tr>";
	}
	$table .= "</tbody>";
	$table .= "</table>";
	if(mysql_num_rows($sqlResult) == 0)
	{
		return "Bisher wurden keine Cocktails gemixt!";
	}
	else
	{
		return $table;
	}
}

function getCocktail($id)
{
	$sql = "SELECT * FROM cocktails WHERE ID = " . $id . " LIMIT 1";
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	while($row = mysql_fetch_assoc($sqlResult))
	{
		return $row;
	}
	
	return false;
}

function getRecipe($id)
{
	$sql = "SELECT i.ID AS ingID, i.Name AS ingName, r.amount AS amount, u.token AS token "
	. "FROM recipes r "
	. "JOIN ingredients i ON r.IID = i.ID "
	. "JOIN units u ON i.UID = u.ID "
	. "WHERE CID = " . $id;
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . mysql_error());
	}
	
	$recipe = array();
	while($row = mysql_fetch_assoc($sqlResult))
	{
		$recipe[] = $row;
	}
	
	return $recipe;
}

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
							. "FROM recipes "
							. "INNER JOIN cocktails "
							. "ON cocktails.ID = recipes.CID "
							. "INNER JOIN ingredients "
							. "ON ingredients.ID = recipes.IID "
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

function checkForSQLInjectionWithRedirect($val, $location)
	{
		if(checkForSQLInjection($val))
		{
			$_SESSION['error'] = "Netter Versuch, doch ist dieses System gegen SQL-Injection gesichert!";
			header('location: ' . $location);
			exit(-3);
		}
	}

	function checkForSQLInjection($val)
	{
		global $connection;
		$res = false;
		if(is_array($val))
		{
      foreach($val as $v)
      {
        $res |= ($v != mysql_real_escape_string($v)); 
      }
      
      return $res;
    }
		
		return ($val != mysql_real_escape_string($val));
	}

	function calcPassWordStrength($pw)
	{
		$staerke  = 0;

		// Prüfen ob Kleinuchstaben enthalten sind
		if (preg_match( "/[a-z]+/", $pw ))
			$staerke++;
		
		// Prüfen ob Großbuchstaben enthalten sind
		if (preg_match( "/[A-Z]+/", $pw ))
			$staerke++;
		
		// Prüfen ob Zahlen enthalten sind
		if (preg_match( "/\d+/", $pw ))
			$staerke++;
	 
		// Prüfen ob Sonderzeichen (!, ?, $, Leerzeichen, usw.) enthalten sind
		if (preg_match( "/\W+/", $pw ))
			$staerke++;
	 
		// PasswortLänge
		if (strlen( $pw ) >= 6 AND strlen( $pw ) <= 15) // Passwort Standardlänge (mindestens 6 Zeichen, maximal 15 Zeichen) prüfen
			$staerke++;
		elseif (strlen( $pw ) > 15) // Passwort relativ sichere Länge (mehr als 15 Zeichen) prüfen
			$staerke = $staerke + 2; // Stärkewert um 2 erhöhen, da die Passwortlänge das wichtigste Sicherheitskriterium darstellt
		elseif (strlen( $pw ) < 6) // Zu kurzes Passwort wird auf niedrigsten Wert herabgestuft
			$staerke = 1;
			
		return $staerke;
	}
		
	function getStrForStaerke($staerke)
	{
		$ausgabe ="";
		// Meldung für die Ausgabe
		switch ($staerke)
		{
			case 1 : $ausgabe = 'Das Passwort ist sehr schwach.'; break;
			case 2 : $ausgabe = 'Das Passwort ist schwach.'; break;
			case 3 : $ausgabe = 'Das Passwort ist OK, aber nicht wirklich sicher.'; break;
			case 4 : $ausgabe = 'Das Passwort ist stark.'; break;
			case 5 : $ausgabe = 'Das Passwort ist sehr stark.'; break;
			case 6 : $ausgabe = 'So und nicht anders sollte ein sicheres Passwort aussehen!'; break;
			default: $ausgabe = 'Bitte ein Passwort eingeben.'; break;
		}
		
		return $ausgabe;
	}
		
	function concatArr($arr)
	  {
		$result = "";
		
		foreach($arr as $ele)
		{
		  $result .= $ele . "<br>"; 
		}
		
		return $result;
	  }
		  
	function isWeakPW($str)
	{
	$strength = calcPassWordStrength($str);
	switch($strength)
	{
		case 1:
		case 2:
			$_SESSION['error'] = getStrForStaerke($strength);
			break;
		case 3:
			$_SESSION['warning'] = getStrForStaerke($strength);
			break;
		case 4:
		case 5:
		case 6:
			$_SESSION['success'] = getStrForStaerke($strength);
			break;
	}

	return $strength <= 2;
	}
		  
	function getRandomSalt()
	{
	mt_srand(microtime(true)*100000 + memory_get_usage(true));
	return md5(uniqid(mt_rand(), true));
	}
		  
	function validateDate($strDate)
	{
		// previous to PHP 5.1.0 you would compare with -1, instead of false
		return (!($timestamp = strtotime($strDate)) === false);
	}

	function validateFactor($strFactor)
	{
		return is_numeric($strFactor);
	}
	
	function doesUserExists($user)
  {
    $sql = "SELECT user FROM users WHERE user = '" . $user . "'";
    $query = mysql_query($sql);
    $anzahl = mysql_num_rows($query);
    
    return $anzahl >= 1;
  }
  
  function doesUserExistsWithRedirect($user, $location)
  {
    if(doesUserExists($user))
    {
       $_SESSION['error'] = "Ein Nutzer mit diesem Namen existiert bereits.";
			header('location: ' . $location);
			exit(-4);
    }
  }
  
  function isValidName($name)
  {
    return !preg_match('/[^a-z \.üÜäAöÖß-]/i', $name);
  }
  
  function isValidNameWithRedirect($name, $location)
  {
     if(!isValidName($name))
    {
       $_SESSION['error'] = "Der Name '". $name ."' ist ungülitg.";
			header('location: ' . $location);
			exit(-5);
    }
  }
  
  function resizeImage ($filepath_old, $filepath_new, $image_dimension, $scale_mode = 0) { 
	if (!(file_exists($filepath_old)) || file_exists($filepath_new)) return false; 

	$image_attributes = getimagesize($filepath_old); 
	$image_width_old = $image_attributes[0]; 
	$image_height_old = $image_attributes[1]; 
	$image_filetype = $image_attributes[2]; 

	if ($image_width_old <= 0 || $image_height_old <= 0) return false; 
	$image_aspectratio = $image_width_old / $image_height_old; 

	if ($scale_mode == 0) { 
		$scale_mode = ($image_aspectratio > 1 ? -1 : -2); 
	} elseif ($scale_mode == 1) { 
		$scale_mode = ($image_aspectratio > 1 ? -2 : -1); 
	} 

	if ($scale_mode == -1) { 
		$image_width_new = $image_dimension; 
		$image_height_new = round($image_dimension / $image_aspectratio); 
	} elseif ($scale_mode == -2) { 
		$image_height_new = $image_dimension; 
		$image_width_new = round($image_dimension * $image_aspectratio); 
	} else { 
		return false; 
	} 

	switch ($image_filetype) { 
		case 1: 
			$image_old = imagecreatefromgif($filepath_old); 
			$image_new = imagecreate($image_width_new, $image_height_new); 
			imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old); 
			imagegif($image_new, $filepath_new); 
		break; 

		case 2: 
			$image_old = imagecreatefromjpeg($filepath_old); 
			$image_new = imagecreatetruecolor($image_width_new, $image_height_new); 
			imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old); 
			imagejpeg($image_new, $filepath_new); 
		break; 

		case 3: 
			$image_old = imagecreatefrompng($filepath_old); 
			$image_colordepth = imagecolorstotal($image_old); 

			if ($image_colordepth == 0 || $image_colordepth > 255) { 
			 $image_new = imagecreatetruecolor($image_width_new, $image_height_new); 
			} else { 
			 $image_new = imagecreate($image_width_new, $image_height_new); 
			} 

			imagealphablending($image_new, false); 
			imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old); 
			imagesavealpha($image_new, true); 
			imagepng($image_new, $filepath_new); 
		break; 

		default: 
			return false; 
	} 

	imagedestroy($image_old); 
	imagedestroy($image_new); 
	return true; 
 }
 
 function setWatermark($pathToImage, $size)
 {
	include_once 'constants.php';
	// Wasserzeichen und Foto laden
	$tmp_Watermark = "_tmp_watermark.png";
	resizeImage("watermark.png", $tmp_Watermark, $size);
	$stamp = imagecreatefrompng($tmp_Watermark);
	$im = imagecreatefromjpeg($pathToImage);

	// Ränder für Wasserzeichen festlegen, dessen Höhe und Breite bestimmen 
	$marge_right = 10;
	$marge_bottom = 10;
	$sx = imagesx($stamp);
	$sy = imagesy($stamp);
	 
	// Wasserzeichen auf das Foto kopieren, die Position berechnet sich dabei aus
	// den Rändern und der Bildbreite
	imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

	// Ausgeben und aufräumen
	//header('Content-type: image/png');
	imagepng($im, $pathToImage);
	imagedestroy($im);
	unlink($tmp_Watermark);
}

?>
