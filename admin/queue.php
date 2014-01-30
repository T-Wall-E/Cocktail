<?php
// Untested CODE!!!

        echo "<h2>Cocktail-Warteschlange</h2>";
        
        $form = "<form action='admin.php' method='POST'>";
        $form .= "<input type='submit' name='clear' value='Warteschlange leeren'>";
        $form .= "</form>";
        
        echo $form;
        
        if(isset($_POST['clear']))
        {
              $dir = "..".DIRECTORY_SEPARATOR."queue";
              $count = 0;
              foreach (scandir($dir) as $item) {
                  if ($item == '.' || $item == '..') continue;
                  if(unlink($dir.DIRECTORY_SEPARATOR.$item))
                  {
                    $count++;
                  }
                  else
                  {
                    $_SESSION['error'] = "Fehler bei min. einer Datei!";
                  }
              }

        }
        
        echo "Hier folgt eine Auflistung aller Dateien, die sich in der Warteschlange befinden...";
?>
