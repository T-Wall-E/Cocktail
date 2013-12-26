<?php
session_start();

if(isset($_POST['cocktailID']))
{
	$filename = "queue/" . date("Ymd-His").'.txt';

	$entry = date("Ymd-H:i:s") . "\t" . $_POST['cocktailID'] . "\t" . $_POST['userID'];

	if (!$handle = fopen($filename, "w+")) {
		$_SESSION['error'] = "Kann die Datei $filename nicht öffnen";
		
		header('location: ' . $_POST['redirect']);
	}
	if (!fwrite($handle, $entry)) {
		$_SESSION['error'] = "Kann in die Datei $filename nicht schreiben";
		die("hier");
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