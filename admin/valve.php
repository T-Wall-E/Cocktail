<?php
if(isset($_SESSION['GID']))
{
	switch($_SESSION['GID'])
	{
		case 1:
		case 2:
			echo "<h2>Ventile</h2>";
			echo "<p>Hier soll man die &Ouml;ffnungszeit f&uuml;r einen Zentiliter und die Schrittzahl zwischen den Ventilen einstellen k&ouml;nnen.</p>";

	break;
	}
}
?>