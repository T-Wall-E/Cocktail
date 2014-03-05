<?php
if(isset($_SESSION['GID']))
{
	switch($_SESSION['GID'])
	{
		case 1:
		case 2:
			echo "<h2>Motor</h2>";
			echo "<p>Hier soll man Einstellungen zum Schrittmotor vornehmen k&ouml;nnen.</p>";
	
	break;
	}
}
?>