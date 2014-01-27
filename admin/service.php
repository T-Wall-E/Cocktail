<?php
	echo "<h2>Cocktail-Service</h2>";
	
	$form = "<form action='admin.php' method='POST'>";
	$form .= "<input type='submit' name='start' value='Service starten'>";
	$form .= "<input type='submit' name='stop' value='Service stoppen'>";
	$form .= "<input type='submit' name='restart' value='Service neustarten'>";
	$form .= "</form>";
	
	echo $form;
	
	if(isset($_POST['start']))
	{
		echo "TODO: Starten";
	}
	
	if(isset($_POST['stop']))
	{
		echo "TODO: Stoppen";
	}
	
	if(isset($_POST['restart']))
	{
		echo "TODO: Neustarten";
	}
?>