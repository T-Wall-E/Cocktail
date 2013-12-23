<?php
/*
#	Author: Tobias Wallewein
#
#	�bersicht �ber den aktuell eingeloggten User
*/
	session_start();
	$title = "Profil";
	include_once "head.php";
	include_once "functions.php";
	
	if(isset($_POST['update']))
	{
	  if($_POST['uid'] != $_SESSION['UID'])
	  {
		$_SESSION['error'] = "Betrugsversuch!";
		header('location: user.php?uid='.$_POST["uid"]);
		exit(-4);
	  }
	  
		checkForSQLInjectionWithRedirect($_POST['uid'], "user.php?uid=".$_POST['uid']);
		checkForSQLInjectionWithRedirect($_POST['name'], "user.php?uid=".$_POST['uid']);
		checkForSQLInjectionWithRedirect($_POST['lastname'], "user.php?uid=".$_POST['uid']);
		checkForSQLInjectionWithRedirect($_POST['ava'], "user.php?uid=".$_POST['uid']);
		checkForSQLInjectionWithRedirect($_POST['gender'], "user.php?uid=".$_POST['uid']);
		checkForSQLInjectionWithRedirect($_POST['birthdate'], "user.php?uid=".$_POST['uid']);
		
		isValidNameWithRedirect($_POST['name'], "user.php");
		isValidNameWithRedirect($_POST['lastname'], "user.php");
		
		// TODO: Datum checken!
		$postBirthdate = date( 'Y-m-d', strtotime($_POST['birthdate']));

		$errors = array();
		
		if(count($errors) > 0)
		{
		  $_SESSION['error'] = concatArr($errors);
		  header('location: user.php?uid='.$_POST["uid"]);
		  exit(-3);
		}
		else
		{
		  $sql = "UPDATE users " .
				"SET " .
				"name='" . $_POST['name'] ."', " .
				"lastname='" . $_POST['lastname'] ."', " .
				"ava='" . $_POST['ava'] ."', " .
				"gender='" . $_POST['gender'] ."', " .
				"birthdate='" . $postBirthdate ."' " .
				"WHERE id=" . $_POST['uid'];
		  mysql_query($sql) or die (mysql_error());
		  $_SESSION['error'] = "";
		  $_SESSION['name'] = $_POST['lastname'];
		  $_SESSION['surname'] = $_POST['name'];
		  
		 header('location: user.php?uid='.$_POST["uid"]);
		  
		  exit();
		}
	  }
				  
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link">Cocktail-Liste</a>
						<!-- New submenu level -->
					</li>

					<li><a href="/Cocktail/allocation.php" title="Belegung" class="link">Belegung</a>	
						<!-- New submenu level -->
					</li>
					<?php
						if(isset($_SESSION['UID']))
						{
							echo "<li>";
							echo 	"<a href='/Cocktail/user.php?uid=" . htmlspecialchars($_SESSION['UID']) ."' title='Dein Profil' class='current'>Dein Profil</a>";
							echo	"<a href='/Cocktail/history.php?uid=" . htmlspecialchars($_SESSION['UID']) . "' title='Verlauf' class='link'>Verlauf</a>";
							echo "</li>";
						}
					?>
			</ul>
		</nav><!-- #navigation end -->
	</header><!-- #header end -->
	
	<div id="content" class="clearfix"><!-- #content start -->
		<div id="main" role="main" class="clearfix"><!-- #main start -->
			<article class="post" role="article" itemscope itemtype="http://schema.org/BlogPosting"><!-- .post start -->
			<?php
			$userArray = getUser(htmlspecialchars($_GET['uid'])); 
			
			if(!$userArray)
			{
				echo "<header><!-- header start -->";
				echo "	<h2 class='page-title' itemprop='headline'>Profil existiert nicht.</h2>";
				echo "</header><!-- header end -->";
			}
			else
			{
				echo "<header><!-- header start -->";
				echo "	<h2 class='page-title' itemprop='headline'>Profil von " . $userArray['user'] . "</h2>";
				echo "</header><!-- header end -->";
								
				$overView = "<p><img id='ava' src='".$userArray["ava"]."' alt='".$userArray["ava"]."'></p>";
				$overView .= "<table id='smalltable'>";
				
				$overView .=  "<tr>";
				$overView .=  "<td>";
				$overView .=  "<strong>Username</strong>";
				$overView .=  "</td>";
				$overView .=  "<td>";
				$overView .=  $userArray["user"];
				$overView .=  "</td>";
				$overView .=  "</tr>";					
				
				$overView .=  "<tr>";
				$overView .=  "<td>";
				$overView .=  "<strong>Vorname</strong>";
				$overView .=  "</td>";
				$overView .=  "<td>";
				$overView .=  $userArray["name"];
				$overView .=  "</td>";
				$overView .=  "</tr>";
				
				$overView .=  "<tr>";
				$overView .=  "<td>";
				$overView .=  "<strong>Nachname</strong>";
				$overView .=  "</td>";
				$overView .=  "<td>";
				$overView .=  $userArray["lastname"];
				$overView .=  "</td>";
				$overView .=  "</tr>";
				
				$overView .=  "<tr>";
				$overView .=  "<td>";
				$overView .=  "<strong>Geschlecht</strong>";
				$overView .=  "</td>";
				$overView .=  "<td>";
				$overView .=  $userArray["gender"] == 0 ? "k.A." : ($userArray["gender"] == 1 ? "m�nnlich" : ($userArray["gender"] == 2 ? "weiblich" : ($userArray["gender"] == 9 ? "Undefiniert" : "")));
				$overView .=  "</td>";
				$overView .=  "</tr>";
				
				$overView .=  "<tr>";
				$overView .=  "<td>";
				$overView .=  "<strong>Geburtstag</strong>";
				$overView .=  "</td>";
				$overView .=  "<td>";
				$birthDate = strtotime($userArray["birthdate"]);
				$overView .=  date('d.m.Y', $birthDate);
				$overView .=  "</td>";
				$overView .=  "</tr>";
				
				
				
				$overView .=  "<tr>";
				$overView .=  "<td>";
				$overView .=  "<strong>Cocktail-Anzahl</strong>";
				$overView .=  "</td>";
				$overView .=  "<td>";
				$overView .=  "TODO: Muss noch implementiert werden. ;)";
				$overView .=  "</td>";
				$overView .=  "</tr>";
				
				$overView .=  "</table>";
			
				echo $overView;
			
				if($userArray['id'] == $_SESSION['UID'])
				{
					echo "<hr>";
					echo "<strong>";
					echo "<p>Hier kannst du �nderungen vornehmen:</p>";
					echo "</strong>";

					$form = "<form action='user.php' method='post'>";
					$form .= "<input type='hidden' name='uid' value='" . $userArray["id"] . "' />";
					$dir    = 'avatar/Tux';
					$files = array_diff(scandir($dir), array('..', '.'));
					$form .= "<div style='overflow: auto; width:100%; height:200px;'>";
					foreach ($files as $value)
					{
							$form .= '<img class="clickableimg" id="'.$value.'" src="'. $dir . '/' .$value.'" />';
					}
					$form .= "</div>";
					$form .= "<hr>";
					$form .= "<table id='smalltable'>";
					$form .=  "<tr>";
					$form .=  "<td>";
					$form .=  "Gew�hltes Bild:";
					$form .=  "</td>";
					$form .=  "<td>";
					$form .= "<img id='selectedAva' src='".$userArray["ava"]."' alt='".$userArray["ava"]."'>";
					$form .= "<input type='hidden' id='selectedAvaInput' name='ava' value='" . $userArray["ava"] . "' />";
					$form .=  "</td>";
					$form .=  "</tr>";
					$form .=  "<tr>";
					$form .=  "<td>";
					$form .=  "Vorname";
					$form .=  "</td>";
					$form .=  "<td>";
					$form .= "<input type='text' name='name' value='" . $userArray["name"] . "' />";
					$form .=  "</td>";
					$form .=  "</tr>";
					$form .=  "<tr>";
					$form .=  "<td>";
					$form .=  "Nachname";
					$form .=  "</td>";
					$form .=  "<td>";
					$form .= "<input type='text' name='lastname' value='" . $userArray["lastname"] . "' />";
					$form .=  "</td>";
					$form .=  "</tr>";	
					$form .=  "<tr>";
					$form .=  "<td>";
					$form .=  "Geschlecht";
					$form .=  "</td>";
					$form .=  "<td>";
					$form .= "<p><input type='radio' name='gender' value='0' " . ($userArray["gender"] == 0 ? "checked='checked'" : "") . "/> Keine Angabe</p>";
					$form .= "<p><input type='radio' name='gender' value='1' " . ($userArray["gender"] == 1 ? "checked='checked'" : "") . "/> m�nnlich</p>";
					$form .= "<p><input type='radio' name='gender' value='2' " . ($userArray["gender"] == 2 ? "checked='checked'" : ""). "/> weiblich</p>";
					$form .= "<p><input type='radio' name='gender' value='9' " . ($userArray["gender"] == 9 ? "checked='checked'" : "") . "/> Weder noch</p>";
					$form .=  "</td>";
					$form .=  "</tr>";	
					$form .=  "<tr>";
					$form .=  "<td>";
					$form .=  "Geburtstag";
					$form .=  "</td>";
					$form .=  "<td>";
					$form .= "<input type='date' name='birthdate' value='" . $userArray["birthdate"] . "' />";
					$form .=  "</td>";
					$form .=  "</tr>";	
					$form .=  "</table>";	
					
					$form .= "<input type='submit' name='update' value='�nderungen �bernehmen'>";
					$form .= "</form>";
					
					echo $form;
				}
			}
		?>
				<script>
					jQuery(".clickableimg").click(function() {
						var choosenpic = jQuery(this).attr('id');
						var newPic = <?php echo '"'. $dir . '/"'; ?> + choosenpic;
						jQuery("#selectedAvaInput").val(newPic);
						jQuery("#selectedAva").attr("src", newPic);
						jQuery("#selectedAva").attr("alt", newPic);
					});
				</script>
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