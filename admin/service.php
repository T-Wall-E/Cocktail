<?php
	include_once "functions.php";
	
	echo "<h2>Cocktail-Service</h2>";
	
	$form = "<form action='admin.php' method='POST'>";
	$form .= "<p>Dies startet den Dienst, falls er nicht schon l&auml;uft.</br>";
	$form .= "<input type='submit' name='start' value='Service starten'></p>";
	$form .= "<p>Achtung! Hier wird der Dienst abgebrochen, falls er noch arbeitet kann es zu Problemen f&uuml;hren!</br>";
	$form .= "<input type='submit' name='stop' value='Service stoppen'></p>";
	$form .= "<p>Achtung! Hier wird der zun&auml;chst Dienst abgebrochen, falls er noch arbeitet kann es zu Problemen f&uuml;hren!</br>";
	$form .= "<input type='submit' name='restart' value='Service neustarten'></p>";
	$form .= "</form>";

	echo $form;
	
	if(isset($_POST['start']))
	{
		exec('sudo /var/sudoWebScript.sh cocktailstart', $CocktailStartOutput, $error);
        if(count($CocktailStartOutput) > 0)
        {
			$_SESSION['success'] = "";
			foreach($CocktailStartOutput as $ele)
			{
				$_SESSION['success'] .= $ele;
				$_SESSION['success'] .= "</br>";
			}

			// Temp-Datei anlegen um den Dienst zu starten (Dateien die nicht auf .cocktail enden, werden vom Dienst gelöscht
			$tmpFilename = $_SERVER["DOCUMENT_ROOT"] ."/Cocktail/queue/" . "temp.tmp";
			if (!$tmpFileHandle = fopen($tmpFilename, "w")) {
				$errors[] = "Kann die Datei $tmpFilename nicht &ouml;ffnen";
				$_SESSION['error'] = concatArr($errors);
			}
			if (!fwrite($tmpFileHandle, $entry)) {
				$errors[] = "Kann in die Datei $tmpFilename nicht schreiben";
				$_SESSION['error'] = concatArr($errors);
			}
			
			fclose($tmpFileHandle);
        }
	}
	
	if(isset($_POST['stop']))
	{
		exec('sudo /var/sudoWebScript.sh cocktailstop', $CocktailStopOutput, $error);
        if(count($CocktailStopOutput) > 0)
        {
			$_SESSION['success'] = "";
			foreach($CocktailStopOutput as $ele)
			{
				$_SESSION['success'] .= $ele;
				$_SESSION['success'] .= "</br>";
			}
        }
	}
	
	if(isset($_POST['restart']))
	{
		$_SESSION['success'] = "";

		exec('sudo /var/sudoWebScript.sh cocktailstop', $output, $error);
        if(count($output) > 0)
        {
			foreach($output as $ele)
			{
				$_SESSION['success'] .= $ele;
				$_SESSION['success'] .= "</br>";
			}
        }

		exec('sudo /var/sudoWebScript.sh cocktailstart', $output, $error);
        if(count($output) > 0)
        {
			foreach($output as $ele)
			{
				$_SESSION['success'] .= $ele;
				$_SESSION['success'] .= "</br>";
			}
        }
	}

	
	if(isset($_SESSION['error']) && $_SESSION['error'] != null && $_SESSION['error'] != "")
	{
		echo "<div class='error'>" . $_SESSION['error'] . "</div>";
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['success']) && $_SESSION['success'] != null && $_SESSION['success'] != "")
	{
		echo "<div class='success'>" . $_SESSION['success'] . "</div>";
		unset($_SESSION['success']);
	}
?>
