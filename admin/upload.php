<?php
	include_once "functions.php";
	include_once "dbCon.php";
	
	if (! isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$client_ip = $_SERVER['REMOTE_ADDR'];
	}
	else
	{
		$client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
					
	if(isset($_POST['fileSubmit']))
	{
		$_SESSION['success'] = "";
		$errors = array();
		
		$uploadDir = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "Cocktail" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR;
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 200000)
		&& in_array($extension, $allowedExts))
		{
			if ($_FILES["file"]["error"] > 0)
			{
				$errors[] = "Return Code: " . $_FILES["file"]["error"] . "<br>";
			}
			else
			{
				$_SESSION['info'] = "Upload: " . $_FILES["file"]["name"] . "<br>";
				$_SESSION['info'] .= "Type: " . $_FILES["file"]["type"] . "<br>";
				$_SESSION['info'] .= "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				$_SESSION['info'] .= "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

				if (file_exists($uploadDir . $_FILES["file"]["name"]))
				{
					$errors[] = $_FILES["file"]["name"] . " already exists. ";
				}
				else
				{
					
					$sqlImageIP = "INSERT INTO imageip "
									. "(Dateiname, IP) "
									. "VALUES "
									. "('" . mysql_real_escape_string($uploadDir. $_FILES["file"]["name"]) . "', '" . $client_ip . "')";
					
					$resultSqlImageIP = mysql_query($sqlImageIP);
					if($resultSqlImageIP)
					{
						$_SESSION['info'] .= "Ihre IP '" . $client_ip . "' wurde gespeichert.<br>";
					}
					else
					{
						$errors[]  = mysql_error();			
					}
					
					move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir. $_FILES["file"]["name"]);
					$_SESSION['success'] .=  "Stored in: " . $uploadDir . $_FILES["file"]["name"];
				}
			}
		}
		else
		{
			$errors[] = "Invalid file";
		}
		
		$_SESSION['error'] = concatArr($errors);
	}
	
	echo "<h2>Bilder-Upload</h2>";
	
	include "infopanel.php";
	
	$form = '<form action="admin.php" method="post" enctype="multipart/form-data">';
	$form .= '<label for="file">Dateiname:</label>';
	$form .= '<input type="file" name="file" id="file"><br>';
	$form .= '<input type="submit" name="fileSubmit" value="Submit">';
	$form .= '</form>';
	
	$rules = "<p>Bitte beachten Sie beim Upload folgende Regeln:</p>";
	$rules .= "<ul>";
	$rules .= "<li>";
	$rules .= "Illegale, pornografische, Bilder die gegen das Deutsche Gesetz, oder Urheberrecht verstoßen sind nicht gestattet!";
	$rules .= "</li>";
	$rules .= "<li>";
	$rules .= "Das hochgeladene Bild darf nicht die Privatsphäre und Rechte/Ehre/W&uuml;rde anderer verletzen!";
	$rules .= "</li>";
	$rules .= "<li>";
	$rules .= "Der Seitenbetreiber haftet in keinem Fall für den Inhalt der hochgeladenen Bilder.";
	$rules .= "</li>";
	$rules .= "<li>";
	$rules .= "Der Seitenbetreiber ist stets bemüht Bilder, die gegen die Regeln verstoßen schnellstmöglich zu entfernen.";
	$rules .= "</li>";
	$rules .= "<li>";
	$rules .= "Als Missbrauch gemeldete Bilder werden umgehend vom Seitenbetreiber gelöscht";
	$rules .= "</li>";
	$rules .= "<li>";
	$rules .= "Aus rechtlichen Gr&uuml;nden wird ihre IP-Adresse: '" . $client_ip . "' mitgespeichert. (§113a TKG)";
	$rules .= "</li>";
	$rules .= "</ul>";
	
	echo $rules;
	echo $form;	
?>