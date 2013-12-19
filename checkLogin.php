<?php
  session_start();
  
  include_once("db_conf.php");
  include_once("functions.php");
  include_once("dbCon.php");
     
    
  if(isset($_POST['login']))
  {
	checkForSQLInjectionWithRedirect($_POST['user'], "index.php");
	checkForSQLInjectionWithRedirect($_POST['pw_input'], "index.php");
	
    $sql = "SELECT * FROM users WHERE user = '". $_POST['user'] . "';";
    $query = mysql_query($sql) or die("Anfrage nicht erfolgreich");
    $anzahl = mysql_num_rows($query);
    if($anzahl == 1)
    {
      while ($data = mysql_fetch_array($query)){
          if($_POST['user'] == $data['user'])
          {
            list($pw, $stored_salt) = explode('$', $data['password']);
            $hashandsalted = md5($_POST['pw_input'].$stored_salt) . '$' . $stored_salt;

            if($data['password'] == $hashandsalted) {
 
               $_SESSION['UID'] = $data['ID'];
               $_SESSION['user'] = $_POST['user'];
               $_SESSION['name'] = $data['name'];
               $_SESSION['surname'] = $data['surname'];
               $_SESSION['GID'] = $data['user_group'];
               $_SESSION['error'] = "";
               
               header('location: index.php');
			   
               exit();
            }
            else
            {
              $_SESSION['error'] = "Passwort falsch";
              header('location: index.php');
              exit(-1);
            }
          }
          else
          {
            $_SESSION['error'] = "Nutzer falsch";
            header('location: index.php');
            exit(-2);
          }
      }
    }
    else
    {
		$_SESSION['error'] = "Nutzer falsch";
		header('location: index.php');
		exit(-2);
    }
  }
  else if(isset($_POST['register']))
  {
      header('location: register.php');
      exit();
  }
?>

