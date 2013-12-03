<?php

if(isset($_POST['cocktailID']))
{
	echo "In die Warteschlange eintragen: " . $_POST['cocktailID'];
	$filename = 'test.txt';

	$entry = date("Ymd-H:i:s") . "\t" . $_POST['cocktailID'] . "\t" . "USER" . "\n";

	if (!$handle = fopen($filename, "a+")) {
		 print "Kann die Datei $filename nicht öffnen";
		 exit;
	}
	if (!fwrite($handle, $entry)) {
		print "Kann in die Datei $filename nicht schreiben";
		exit;
	}

	print "Fertig, in Datei $filename wurde $entry geschrieben";

	fclose($handle);
	print "Die Datei $filename ist nicht schreibbar";

}
else
{
die("Keine ID gefunden");
}

?>