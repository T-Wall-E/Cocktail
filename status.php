<?php
	$thisFileContent = file("status.txt");
	
	for($i=count($thisFileContent)-1; $i>=0; $i--)
	{
		echo $thisFileContent[$i];
	}
?>