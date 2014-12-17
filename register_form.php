<?php
include_once "functions.php";

if(isRegisterAllowed())
{
	$form = "";
	$form .= "<form action='' method='POST'>";
		$form .= "<table border = '1'>";
			$form .= "<tr>";
				$form .= "<td class='normal'>Benutzer:</td>";
				$form .= "<td class='normal'><input type='text' name='user' value='" . $_SESSION['tmp_user'] . "'></td>";
				$form .= "<td class='normal'>";
					$form .= "<img ";
						$form .= "src='sunrise-1.0.0/img/hint.png'";
						$form .= "title='Ein Benutzername muss einzigartig sein!'";
						$form .= "alt='Hinweis!'";
					$form .= "/>";
				$form .= "</td>";
			$form .= "</tr>";
			$form .= "<tr>";
				$form .= "<td class='normal'>Passwort:</td>";
				$form .= "<td class='normal'><input type='password' name='pw'></td>";
				$form .= "<td class='normal'>";
					$form .= "<img ";
						$form .= "src='sunrise-1.0.0/img/hint.png'";
						$form .= "title='Muss eine Stärke von mindestens 2 haben.";
							$form .= "\n Die Stärke berechnet sich wie folgt:";
							$form .= "\n Wenn Kleinbuchstaben enthalten sind: +1";
							$form .= "\n Wenn Großbuchstaben enthalten sind: +1";
							$form .= "\n Wenn Zahlen enthalten sind: +1";
							$form .= "\n Wenn Sonderzeichen enthalten sind: +1";
							$form .= "\n Wenn die Gesamtlänge zwischen 6 und 15 liegt: +1";
							$form .= "\n Wenn die Gesamtlänge größer ist als 15: +2";
							$form .= "\n Wenn die Gesamtlänge nicht länger als 6 ist,";
							$form .= "\n wird der Wert auf 1 gesetzt, unabhängig davon, wie viele Punkte man zuvor erhält.'";
						$form .= "alt='Hinweis!'";
					$form .= "/>";
				$form .= "</td>";
			$form .= "</tr>";
			$form .= "<tr>";
				$form .= "<td class='normal'>Passwort best&auml;tigen:</td>";
				$form .= "<td class='normal'><input type='password' name='pw_confirm'></td>";
				$form .= "<td class='normal'>";
					$form .= "<img ";
						$form .= "src='sunrise-1.0.0/img/hint.png'";
						$form .= "title='Dieses Passwort muss mit dem vorherigen übereinstimmen.'";
						$form .= "alt='Hinweis!'";
					$form .= "/>";
				$form .= "</td>";
			$form .= "</tr>";
			$form .= "<tr>";
				$form .= "<td class='normal'>Vorname:</td>";
				$form .= "<td class='normal'><input type='text' name='surname' value='" . $_SESSION['tmp_surname'] . "'></td>";
				$form .= "<td class='normal'>";
					$form .= "<img ";
						$form .= "src='sunrise-1.0.0/img/hint.png'";
						$form .= "title='Es sind nur gültige Namen erlaubt.'";
						$form .= "alt='Hinweis!'";
					$form .= "/>";
				$form .= "</td>";
			$form .= "</tr>";
			$form .= "<tr>";
				$form .= "<td class='normal'>Nachname:</td>";
				$form .= "<td class='normal'><input type='text' name='name' value='" . $_SESSION['tmp_name'] . "'></td>";
				$form .= "<td class='normal'>";
					$form .= "<img ";
						$form .= "src='sunrise-1.0.0/img/hint.png'";
						$form .= "title='Es sind nur gültige Namen erlaubt.'";
						$form .= "alt='Hinweis!'";
					$form .= "/>";
				$form .= "</td>";
			$form .= "</tr>";
		$form .= "</table>";
		$form .= "<input class='buttonblue' type='submit' name='register'value='Registrieren'>";
	$form .= "</form>";
	
	echo $form;
}
else
{
	echo "<p>Zur Zeit ist die Registrierung deaktiviert. Versuchen Sie es sp&auml;ter nochmal, oder wenden sich an die Administratoren.</p>";
}
?>
