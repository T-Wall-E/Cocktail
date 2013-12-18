<?php
	session_start();

	$title = "Cocktail-Liste";
	include_once "head.php";
  
	include_once("db_conf.php");
	include_once("functions.php");

    include_once 'dbCon.php';
    
    if(isset($_POST['register']))
    {
      // SESSION-Variablen um die Eingabe-Felder wieder auszufüllen
      $_SESSION['tmp_user'] = "";
      $_SESSION['tmp_name'] = "";
      $_SESSION['tmp_surname'] = "";
      
      checkForSQLInjectionWithRedirect($_POST['user'], "register.php");
      checkForSQLInjectionWithRedirect($_POST['pw'], "register.php");
  		checkForSQLInjectionWithRedirect($_POST['pw_confirm'], "register.php");
  		checkForSQLInjectionWithRedirect($_POST['name'], "register.php");
  		checkForSQLInjectionWithRedirect($_POST['surname'], "register.php");
		
		  $_SESSION['tmp_user'] = $_POST['user'];
      $_SESSION['tmp_name'] = $_POST['name'];
      $_SESSION['tmp_surname'] = $_POST['surname'];
		
  		doesUserExistsWithRedirect($_POST['user'], "register.php");
  		isValidNameWithRedirect($_POST['name'], "register.php");
  		isValidNameWithRedirect($_POST['surname'], "register.php");
		
        $errors = array();
        // Schwaches PW
        if(isWeakPW($_POST['pw']))
        {
          $errors[] = $_SESSION['error'];
        }
        
        // Passwörter vergleichen
        if($_POST['pw'] <> $_POST['pw_confirm'])
        {
          $errors[] = "Passw&ouml;rter unterschiedlich!";
        }
        
        if(count($errors) > 0)
        {
          $_SESSION['error'] = concatArr($errors);
		      header('location: register.php');
          exit(-3);
        }
        else
        {
          $salt = sha1(getRandomSalt());
          $hashedandsaltedPW = md5($_POST['pw'].$salt).'$'.$salt; 
              // use sha1 instead of md5
          
          if(is_null($_POST['group']))
            $group = 3;
          else
            $group = $_POST['group'];
          
          $sql = "INSERT INTO users (user, password, name, lastname, user_group ) " .
              "VALUES ('" . $_POST['user'] . "', '" . $hashedandsaltedPW . 
              "', '" . $_POST['surname'] . "', '" . $_POST['name'] . "', '" . 
              $group . "')"; 
          mysql_query($sql) or die (mysql_error());
          $_SESSION['error'] = "";
          $_SESSION['user'] = $_POST['user'];
          $_SESSION['name'] = $_POST['name'];
          $_SESSION['surname'] = $_POST['surname'];
          $_SESSION['GID'] = $group;
          
         header('location: index.php');
          
          exit();
        }
      }
?>
<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<div id="inner-header" class="clearfix"><!-- #inner-header start -->
	
			<!-- Search -->
			<div id="search-wrapper">
				<div id="search-toggle"></div>
				<form  id="SearchForm_SearchForm" action="SearchCocktail.php" method="get" enctype="application/x-www-form-urlencoded">
					<fieldset>
						<legend></legend>
							<div id="Search" class="field text  nolabel"><div class="middleColumn"><input type="text" class="text nolabel" id="SearchForm_SearchForm_Search" name="Search" value="" /></div></div>
							<input class="action " id="SearchForm_SearchForm_action_results" type="submit" name="action_results" value="Go" title="Go" />
					</fieldset>
				</form>
			</div>
			
			<!-- Site title -->
			<h1><a href="index.php" title="Cocktail-Maschine">Cocktail-Maschine</a></h1>
			
			<!-- Site tagline -->
			<p>Lass dir deinen Cocktail mixen!</p>
		
		</div><!-- #inner-header end -->
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link">Cocktail-Liste</a>
						<!-- New submenu level -->			
					</li>

					<li><a href="/Cocktail/allocation.php" title="Belegung" class="link">Belegung</a>	
						<!-- New submenu level -->
					</li>
					
					<li><a href="/Cocktail/user.php" title="Dein Profil" class="link">Dein Profil</a>	
						<!-- New submenu level -->
					</li>
			</ul>
		</nav><!-- #navigation end -->
	</header><!-- #header end -->
	
	<div id="content" class="clearfix"><!-- #content start -->
		<div id="main" role="main" class="clearfix"><!-- #main start -->
			<article class="post" role="article" itemscope itemtype="http://schema.org/BlogPosting"><!-- .post start -->
				<header><!-- header start -->
					<h2 class="page-title" itemprop="headline">Registrieren</h2>
				</header><!-- header end -->
<?php
					   if(isset($_SESSION['error']) && $_SESSION['error'] != null 
                     && $_SESSION['error'] != "")
					   {
						  echo "<div class='error'>" . $_SESSION['error'] . "</div>";
						  unset($_SESSION['error']);
					   }
				?>
				<form action="" method="POST">
					  <table border = "1">
  						<tr>
							<td class='normal'>Benutzer:</td>
							<td class='normal'><input type='text' name='user' value='<?php echo $_SESSION['tmp_user'] ?>'></td>
							<td class='normal'>
							  <img
								src="images/hint.png"
								title="Ein Benutzername muss einzigartig sein!"
								alt="Hinweis!"
							  />
							</td>
						  </tr>
						  <tr>
							<td class='normal'>Passwort:</td>
							<td class='normal'><input type='password' name='pw'></td>
							<td class='normal'>
							  <img 
								src="images/hint.png"
								title="Muss eine Stärke von mindestens 2 haben.

Die Stärke berechnet sich wie folgt:
Wenn Kleinbuchstaben enthalten sind: +1
Wenn Großbuchstaben enthalten sind: +1
Wenn Zahlen enthalten sind: +1
Wenn Sonderzeichen enthalten sind: +1
Wenn die Gesamtlänge zwischen 6 und 15 liegt: +1
Wenn die Gesamtlänge größer ist als 15: +2
Wenn die Gesamtlänge nicht länger als 6 ist,
wird der Wert auf 1 gesetzt, unabhängig davon, wie viele Punkte man zuvor erhält."
                    alt="Hinweis!"
							  />
							</td>
						  </tr>
						  <tr>
							<td class='normal'>Passwort best&auml;tigen:</td>
							<td class='normal'><input type='password' name='pw_confirm'></td>
							<td class='normal'>
							  <img 
								src="images/hint.png"
								title="Dieses Passwort muss mit dem vorherigen übereinstimmen."
								alt="Hinweis!"
							  />
							</td>
						  </tr>
									<tr>
							<td class='normal'>Vorname:</td>
							<td class='normal'><input type='text' name='surname' value='<?php echo $_SESSION['tmp_surname'] ?>'></td>
							<td class='normal'>
							  <img 
								src="images/hint.png"
								title="Es sind nur gültige Namen erlaubt."
								alt="Hinweis!"
							  />
							</td>
						  </tr>
									<tr>
							<td class='normal'>Nachname:</td>
							<td class='normal'><input type='text' name='name' value='<?php echo $_SESSION['tmp_name'] ?>'></td>
							<td class='normal'>
							  <img 
								src="images/hint.png"
								title="Es sind nur gültige Namen erlaubt."
								alt="Hinweis!"
							  />
							</td>
						  </tr>
					  </table>
					  <input class="buttonblue" type='submit' name='register'value='Registrieren'>
					</form>
  				<a class='buttonback' href='login.php'>Zurück zur Anmeldung</a>
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
	
	<!-- Scripts -->
	<script src="sunrise-1.0.0/js/plugins.js"></script>
	<script src="sunrise-1.0.0/js/script.js"></script>
	<script src="sunrise-1.0.0/js/mylibs/helper.js"></script>
	
	<!--[if (lt IE 9) & (!IEMobile)]>
	<script src="sunrise-1.0.0/js/libs/imgsizer.js"></script>
	<![endif]-->
	
	<script>
	// iOS scale bug fix
	MBP.scaleFix();
	
	// Respond.js
	yepnope({
		test : Modernizr.mq('(only all)'),
		nope : ['sunrise-1.0.0/js/libs/respond.min.js']
	});
	</script>
<script>	
Behaviour.register({
	'#SearchForm_SearchForm': {
		validate : function(fromAnOnBlur) {
			initialiseForm(this, fromAnOnBlur);
			

			var error = hasHadFormError();
			if(!error && fromAnOnBlur) clearErrorMessage(fromAnOnBlur);
			if(error && !fromAnOnBlur) focusOnFirstErroredField();
			
			return !error;
		},
		onsubmit : function() {
			if(typeof this.bypassValidation == 'undefined' || !this.bypassValidation) return this.validate();
		}
	},
	'#SearchForm_SearchForm input' : {
		initialise: function() {
			if(!this.old_onblur) this.old_onblur = function() { return true; } 
			if(!this.old_onfocus) this.old_onfocus = function() { return true; } 
		},
		onblur : function() {
			if(this.old_onblur()) {
				// Don't perform instant validation for CalendarDateField fields; it creates usability wierdness.
				if(this.parentNode.className.indexOf('calendardate') == -1 || this.value) {
					return $('SearchForm_SearchForm').validate(this);
				} else {
					return true;
				}
			}
		}
	},
	'#SearchForm_SearchForm textarea' : {
		initialise: function() {
			if(!this.old_onblur) this.old_onblur = function() { return true; } 
			if(!this.old_onfocus) this.old_onfocus = function() { return true; } 
		},
		onblur : function() {
			if(this.old_onblur()) {
				return $('SearchForm_SearchForm').validate(this);
			}
		}
	},
	'#SearchForm_SearchForm select' : {
		initialise: function() {
			if(!this.old_onblur) this.old_onblur = function() { return true; } 
		},
		onblur : function() {
			if(this.old_onblur()) {
				return $('SearchForm_SearchForm').validate(this); 
			}
		}
	}
});

//]]></script>

</body>

</html>
