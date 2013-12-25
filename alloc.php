<?php
include_once 'dbCon.php';

//############## FUNKTIONEN #############
function createTable()
{
  global $connection;
  
  $result = "";
  $result .= "<form method=post action='allocation.php'>";
  $result .= "<table id='smalltable'>";
  $result .= "<thead>";
  $result .= "<tr>";
  $result .= "<th>Ventil</th>";
  $result .= "<th>Zutat</th>";
  $result .= "</tr>";
  $result .= "</thead>";
  
  $sql = "SELECT * FROM `allocation` AS a JOIN `ingredients` AS i ON a.ingredient = i.id";
  $resultset = mysql_query($sql, $connection);
  if (!$resultset)
  {
     $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
     $message .= 'Gesamte Abfrage: ' . $sql;
     die($message);
  }
  
  $i = 0;
  $result .= "<tbody>";
  while ($row = mysql_fetch_array($resultset)) {
      $result .= "<tr>";
      $result .= "<td>#" . $row["valve"] ."</td>";
      $result .= "<td>";
	  switch($_SESSION['GID'])
	  {
		case 1:
		case 2:
			$result .= getComboBox($row["ID"], $row["valve"]);
			break;
		default:
			$result .= getIngredient($row["valve"]);		
	  }
	 
	  $result .= "</td>";
      $result .= "</tr>";
      $i++;
  } //$row = mysql_fetch_array($resultset)
  $result .= "</tbody>";
    
  $result .= "</table>";
  if($_SESSION['GID'] == 1)
  {
	$result .= "<input class='buttonedit' type='submit' name='updateAllocation' value='&Auml;nderungen &uuml;bernehmen'>";
  }
  $result .= "</form>";
  
  return $result;
}

function getComboBox($selectedID, $valve)
{
  global $connection;
  $sql = "SELECT * FROM `ingredients` ORDER BY name";
  $sqlresult = mysql_query($sql, $connection);
  if (!$sqlresult)
  {
     $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
     $message .= 'Gesamte Abfrage: ' . $sql;
     die($message);
  }

  $result = "";
  $result .= "<select name='ing[" . $valve . "]' size='1'>";
  while ($row = mysql_fetch_array($sqlresult))
  {
    $result .=  "<option value='" . $row['ID'] . "' ";
    $result .= $row['ID'] == $selectedID ? "selected" : "";
    $result .= ">" . $row['name'] . "</option>";
  }
  $result .=  "</select>";
  return $result;
}

function getIngredient($valve)
{
  global $connection;
  $sql = "SELECT i.name " .
		"FROM allocation a " .
		"JOIN ingredients i " .
		"ON a.ingredient = i.id " .
		"WHERE a.valve = " . $valve . " " . 
		"LIMIT 1";
  $sqlresult = mysql_query($sql, $connection);
  if (!$sqlresult)
  {
     $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
     $message .= 'Gesamte Abfrage: ' . $sql;
     die($message);
  }

  $result = "";
  while ($row = mysql_fetch_array($sqlresult))
  {
    $result .= $row['name'];
  }
  
  return $result;
}

function checkForUpdates()
{
  global $connection;
      if (isset($_POST['updateAllocation'])) {
         
        // Änderungen aus Tabelle sollen übernommen werden.

        foreach ($_POST['ing'] as $key =>$wert)
        { 
          $sql = "UPDATE `cocktail_machine`.`allocation` SET  `allocation`.`ingredient` = '". $wert ."' WHERE  `allocation`.`valve` =". $key . ";";
          mysql_query($sql, $connection) or die(mysql_error());
        }
        
        
        echo ("Die &Auml;nderungen wurden &uuml;bernommen.<br>");
        
    } //isset($_POST['updateAllocation'])
}
// ######### End of Function ################

	checkForUpdates();
	echo createTable();
?>
