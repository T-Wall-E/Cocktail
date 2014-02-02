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
		exec('sudo /var/sudoWebScript.sh cocktailstart', $CocktailStartOutput, $error);
                if(count($CocktailStartOutput) > 0)
                {
                        $_SESSION['success'] = "";
                        foreach($CocktailStartOutput as $ele)
                        {
                                $_SESSION['success'] .= $ele;
                        }
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
                        }
                }

		exec('sudo /var/sudoWebScript.sh cocktailstart', $output, $error);
                if(count($output) > 0)
                {
                        foreach($output as $ele)
                        {
                                $_SESSION['success'] .= $ele;
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
