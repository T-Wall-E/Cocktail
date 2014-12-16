<?php
	$thisFileContent = file("percent.txt");
	
	for($i=count($thisFileContent)-1; $i>=0; $i--)
	{
		if($thisFileContent[$i] <= 0)
		{
			echo "120px:0%";
		}
		else if ($thisFileContent[$i] >= 100)
		{
			echo "190px:100%";
		}
		else
		{
			$val = 120+70*$thisFileContent[$i]/100;
			echo $val . "px:" . $thisFileContent[$i] . "%";
		}
		//echo $thisFileContent[$i];
	}
?>