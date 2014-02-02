<?php
	echo "<h2>Cocktail-Warteschlange</h2>";
	
	echo "<p>Hier haben Sie die M&ouml;glichkeit alle Cocktails aus der Warteschlange zu l&ouml;schen. (Wenn welche vorhanden sind. ;) )</p>";
	
	
	$queueDir = "queue" . DIRECTORY_SEPARATOR;
	
	if(isset($_POST['clear']))
	{
		$count = 0;
		foreach (scandir($queueDir) as $item)
		{
			if ($item == '.' || $item == '..') continue;
			
			if(unlink($queueDir.$item))
			{
				$count++;
			}
			else
			{
				$_SESSION['error'] = "Fehler bei min. einer Datei!";
			}
		}
		
		if($count > 0)
		{
			$_SESSION['success'] = $count . " ";
			if($count == 1)
			{
				$_SESSION['success'] .= "Datei wurde";
			}
			else
			{
				$_SESSION['success'] .= "Dateien wurden";
			}
			
			$_SESSION['success'] .= " gel&ouml;scht.";
			
		}
		// TODO: Ergebnis

	}
	
	$table = "<table border=\"1\">\n";
	$table .= "<tr><th>#</th><th>Name</th></tr>";
	$count = 0;
	foreach(scandir($queueDir) as $file)
	{
		if ($file == '.' || $file == '..') continue;
		$table .= "<tr>\n";
		$table .= "<td>".++$count."</td>\n";
		$table .= "<td>".$file."</td>\n";
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	
	
	if($count > 0)
	{
		echo $table;
	}
	else
	{
		echo "<p>Aktuell sind keine Cocktails in der Warteschlange gelistet.</p>";
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


	$form = "<form action='admin.php' method='POST'>";
	$form .= "<input type='submit' name='clear' value='Warteschlange leeren'>";
	$form .= "</form>";
	
	echo $form;
?>
