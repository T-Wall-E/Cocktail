<?php
include_once 'dbCon.php';

function getUser($userId)
{
	$sql = "SELECT id, user, name, lastname, user_group, ava, birthdate, gender FROM `users` WHERE id = ".$userId;
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ung�ltige Anfrage: ' . $sql . mysql_error());
	}
	
	while($row = mysql_fetch_assoc($sqlResult))
	{
		return $row;
	}
	
	return false;
}

function getAllocation()
{
	$sql = "SELECT ingredient FROM `allocation`";
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ung�ltige Anfrage: ' . $sql . mysql_error());
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
		die('Ung�ltige Anfrage: ' . $sql . mysql_error());
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

		// Pr�fen ob Kleinuchstaben enthalten sind
		if (preg_match( "/[a-z]+/", $pw ))
			$staerke++;
		
		// Pr�fen ob Gro�buchstaben enthalten sind
		if (preg_match( "/[A-Z]+/", $pw ))
			$staerke++;
		
		// Pr�fen ob Zahlen enthalten sind
		if (preg_match( "/\d+/", $pw ))
			$staerke++;
	 
		// Pr�fen ob Sonderzeichen (!, ?, $, Leerzeichen, usw.) enthalten sind
		if (preg_match( "/\W+/", $pw ))
			$staerke++;
	 
		// PasswortL�nge
		if (strlen( $pw ) >= 6 AND strlen( $pw ) <= 15) // Passwort Standardl�nge (mindestens 6 Zeichen, maximal 15 Zeichen) pr�fen
			$staerke++;
		elseif (strlen( $pw ) > 15) // Passwort relativ sichere L�nge (mehr als 15 Zeichen) pr�fen
			$staerke = $staerke + 2; // St�rkewert um 2 erh�hen, da die Passwortl�nge das wichtigste Sicherheitskriterium darstellt
		elseif (strlen( $pw ) < 6) // Zu kurzes Passwort wird auf niedrigsten Wert herabgestuft
			$staerke = 1;
			
		return $staerke;
	}
		
	function getStrForStaerke($staerke)
	{
		$ausgabe ="";
		// Meldung f�r die Ausgabe
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
    return !preg_match('/[^a-z \.���A���-]/i', $name);
  }
  
  function isValidNameWithRedirect($name, $location)
  {
     if(!isValidName($name))
    {
       $_SESSION['error'] = "Der Name '". $name ."' ist ung�litg.";
			header('location: ' . $location);
			exit(-5);
    }
  }

?>
