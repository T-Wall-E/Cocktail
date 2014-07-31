<?php
if(isset($_SESSION['GID']))
{
	switch($_SESSION['GID'])
	{
		case 1:
		case 2:
		
			$stepsequences = array("HalfStep", "SingleStep", "DoubleStep");
		
			include_once "functions.php";

			if(isset($_POST['motor_update']))
			{
				// Werte in DB speichern
				// TOOD:
				echo "Stepsequence: " . $_POST['stepsequence'] . "<br>";
				echo "Stepintervall: " . $_POST['stepintervall'] . "<br>";
			}

			echo "<h2>Motor</h2>";

			include "infopanel.php";

			
			// Werte aus der Datenbank auslesen und selektierte anzeigen
			$selStepSequence = 0;
			
			$description = "<p>Hier werden Einstellungen zum Schrittmotor vorgenommen. (Werden erst nach einem Neustart des Servuces wirksam)</p>";

			$form = "<form action='admin.php' method='POST'>";
			// StepSequence
			$form .= "<p>Hier wird die Stepsequence festgelegt</br>";
			$form .= "<select name='stepsequence' size='1'>";
			for($i = 0; $i < count($stepsequences); $i++)
			{
				$form .= "<option";
				$form .= $selStepSequence == $i ? " selected>" : "";
				$form .= $stepsequences[$i] . "</option>";
			}
			$form .= "</select>";
			// StepIntervall
			$form .= "<p>Hier wird der Stepintervall festgelegt</br>";
			$form .= "<input type='number' name='stepintervall' min='1' max='10'>";
			
			
			$form .= "<input type='submit' name='motor_update' value='&Auml;nderungen &uuml;bernehmen'></p>";
			$form .= "</form>";

			echo $description;
			echo $form;

	break;
	}
}
?>
