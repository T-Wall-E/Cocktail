<?php
session_start();
include_once "dbCon.php";

if(isset($_POST['cocktailID']))
{
	$errors = array();
	
	
	$sql = "INSERT INTO history (UID, CID) " .
			"VALUES (" . $_POST['userID'] . ", " . $_POST['cocktailID'] . ")";
	$result = mysql_query($sql);
	
	if(!result)
	{
		$errors[] = mysql_error();
		$errors[] = $sql;
		$_SESSION['error'] = concatArr($errors);
		header('location: ' . $_POST['redirect']);
	}


	$filename = "queue/" . date("Ymd-His").'.txt';

	$entry = date("Ymd-H:i:s") . "\t" . $_POST['cocktailID'] . "\t" . $_POST['userID'];

	if (!$handle = fopen($filename, "w+")) {
		$errors[] = "Kann die Datei $filename nicht öffnen";
		$_SESSION['error'] = concatArr($errors);
		header('location: ' . $_POST['redirect']);
	}
	if (!fwrite($handle, $entry)) {
		$errors[] = "Kann in die Datei $filename nicht schreiben";
		$_SESSION['error'] = concatArr($errors);
		header('location: ' . $_POST['redirect']);
	}
	
	fclose($handle);
	
	$_SESSION['success'] = "Fertig, in Datei $filename wurde $entry geschrieben";
	header('location: ' . $_POST['redirect']);
}
else
{
	$_SESSION['error'] = "Keine ID gefunden!";
	header('location: ' . $_POST['redirect']);
}

?>