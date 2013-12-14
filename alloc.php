<?php
include_once 'dbCon.php';

//############## FUNKTIONEN #############
function createTable()
{
  global $connection;
  
  $result = "";
  $result .= "<form method=post action='alloc.php'>";
  $result .= "<table>";
  $result .= "<thead>";
  $result .= "<th>Ventil</th>
          <th>Zutat</th>";
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
  while ($row = mysql_fetch_array($resultset)) {
      $result .= ($i % 2 == 0 ? "<tr>" : "<tr class='odd'>");
      $result .= ("<td>#" . $row["valve"] ."</td>");
      $result .= ("<td>" . getComboBox($row["ID"], $row["valve"]) . "</td>");
      $result .= ("<tr>");
      $i++;
  } //$row = mysql_fetch_array($resultset)
    
  $result .= "</table>";
  $result .= "<input class='buttonedit' type='submit' name='updateAllocation' 
         value='&Auml;nderungen &uuml;bernehmen'>";
  $result .= "</form>";
  
  return $result;
}

function getComboBox($selectedID, $valve)
{
  global $connection;
  $sql = "SELECT * FROM `ingredients`";
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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <title>
	CM - Ventil-Belegung
  </title>
  <link href="style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
<?php
  echo createTable();
?>
  </body>
</html>
