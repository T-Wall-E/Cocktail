<?php
	session_start();

	$title = "Cocktail-Liste";
	include_once "head.php";
	include_once("db_conf.php");
	include_once("functions.php");
	include_once 'dbCon.php';


	// SESSION-Variablen um die Eingabe-Felder wieder auszufüllen
	$_SESSION['tmp_user'] = "";
	$_SESSION['tmp_name'] = "";
	$_SESSION['tmp_surname'] = "";

	if(isset($_POST['register']))
	{
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
		
			if(!isset($_POST['group']) || is_null($_POST['group']))
			{
				$group = 3;
			}
			else
			{
				$group = $_POST['group'];
			}
		
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
?> <body class="clearfix">
	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
				<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link parent">Cocktail-Liste</a>
					<!-- New submenu level -->
				</li>
				
				<li><a href="/Cocktail/ingredients.php" title="Zutaten-Liste" class="link parent">Zutaten-Liste</a>
					
				</li>
				<li><a href="/Cocktail/allocation.php" title="Belegung" class="link">Belegung</a>
					<!-- New submenu level -->
				</li>
				
				<li><a href="/Cocktail/users.php" title="User-Liste" class="link">User-Liste</a>
					<!-- New submenu level -->
				</li>
				
				<?php
				if (isset($_SESSION['user']) && $_SESSION['user'] != null && $_SESSION['user'] != "" && isset($_SESSION['UID']))
				{
					echo "<li><a href='/Cocktail/user.php?uid=" . htmlspecialchars($_SESSION['UID']) . "' title='Dein Profil' class='link parent'>Dein Profil</a>";
					echo "</li>";
				}
				?>
				
				<?php
					if(isset($_SESSION['GID']))
					{
						switch($_SESSION['GID'])
						{
							case 1:
							case 2:
								echo "<ul>";
								echo "<li>";
								echo '<a href="/Cocktail/admin.php" title="Control-Panel" class="link">Control-Panel</a>';
								echo "</li>";
								echo "</ul>";
								break;
						}
					}
				?>
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

					include "register_form.php";
				?>
				<a class='buttonback' href='index.php'>Zur&uuml;ck zur Anmeldung</a>
			</article><!-- .post end -->
		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php"; ?> </body> </html>
