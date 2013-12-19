<?php
if (isset($_SESSION['user']) && $_SESSION['user'] != null 
        && $_SESSION['user'] != "") {
    echo "<div id='logoutDiv'>";
    echo "<form id='logoutForm' action='index.php' method='POST'>";
    echo "<input id='logoutButton' type='submit' name='logout'
            value='Abmelden'>";
    echo "</form>";
    echo "</div>";
} // isset($_SESSION['user']) && $_SESSION['user'] != null 
  // && $_SESSION['user'] != ""
?> 
