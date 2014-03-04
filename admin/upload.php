<?php
	include_once "functions.php";
	
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

	echo $form;	
?>