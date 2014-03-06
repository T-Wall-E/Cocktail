<?php
	session_start();
	$title = "Neue Zutat";
	include_once "functions.php";
	include_once "head.php";
	include_once "dbCon.php";
	
	if(isset($_POST['add']))
    {
		$_SESSION['error'] = "";
		
		checkForSQLInjectionWithRedirect($_POST['name'], "addIngredient.php");
		checkForSQLInjectionWithRedirect($_POST['unit'], "addIngredient.php");
		checkForSQLInjectionWithRedirect($_POST['vol'], "addIngredient.php");
	
		$name=$_POST['name'];
		$unitID=$_POST['unit'];
		$vol = $_POST['vol'];
		
		$errors = array();
		
		$sqlInsertIngredient = "INSERT INTO `ingredients` (Name, UID, vol) " .
							"VALUES ('" . $name . "', '" . $unitID . "', " . $vol . ")";
							
		$resultInsertIngredient = mysql_query($sqlInsertIngredient);
		if(!$resultInsertIngredient)
		{
			$errors[]  = mysql_error();			
		}
		
		if(count($errors) > 0)
        {
			$_SESSION['error'] = concatArr($errors);
			header("location: addIngredient.php");
		}
		
		$iid = mysql_insert_id();
		
		if(!$iid)
		{
			$errors[]  = mysql_error();
		}
		
		if(count($errors) > 0)
        {
			$_SESSION['error'] = concatArr($errors);
			header("location: addIngredient.php");
		}
		
		$_SESSION['success'] = $name . " wurde erfolgreich hinzugefügt!";
	}
	
	function getUnitCombo()
	{
		$result = "";
		
		$sql = "SELECT * FROM `units`";
		$sqlResult = mysql_query($sql);
		$result = "<select name='unit' size='1'>";
		while($row = mysql_fetch_assoc($sqlResult))
		{
			$result .=  "<option value='" . $row['ID'] . "'>" . $row['name'] . " (" . $row['token'] . ")</option>";
		}
		$result .= "</select>";
		
		return $result;
	}
	
	function getIngredientAddForm()
	{
		$result = "<form name='newIngForm' action='addIngredient.php' method='POST' onsubmit='return chkFormular()'>";
		$result .= "<table>";
		$result .= "<tr>";
		$result .= "<td>";
		$result .= "Name";
		$result .= "</td>";
		$result .= "<td>";
		$result .= "<input type='text' name='name' value='' />";
		$result .= "</td>";
		$result .= "</tr>";
		$result .= "<tr>";
		$result .= "<td>";
		$result .= "Einheit";
		$result .= "</td>";
		$result .= "<td>";
		$result .= getUnitCombo();
		$result .= "</td>";
		$result .= "</tr>";
		$result .= "<tr>";
		$result .= "<td>";
		$result .= "Volumenprozent";
		$result .= "</td>";
		$result .= "<td>";
		$result .= "<input type='text' name='vol' value='0' />";
		$result .= "</td>";
		$result .= "</tr>";
		$result .= "</table>";
		$result .= "<input type='submit' name='add' value='Zutat eintragen' />";
		$result .= "</form>";
		
		return $result;
	}
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one <?php echo isAdminBy_SESSION() ? "level-two" : "" ?>">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Cocktail-Liste</a>
						<!-- New submenu level -->
					</li>
					
					<li><a href="/Cocktail/ingredients.php" title="Zutaten-Liste" class="link <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Zutaten-Liste</a>
						<?php
							if(isAdminBy_SESSION())
							{
								echo "<ul>";
								echo "<li>";
								echo '<a href="/Cocktail/addIngredient.php" title="Neue Zutat" class="current">Neue Zutat</a>';
								echo "</li>";
								echo "</ul>";
							}
						?>	
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
						if(isAdminBy_SESSION())
						{
							echo "<li>";
							echo '<a href="/Cocktail/admin.php" title="Control-Panel" class="link">Control-Panel</a>';
							echo "</li>";
						}
					?>
			</ul>
		</nav><!-- #navigation end -->
	</header><!-- #header end -->
	
	<div id="content" class="clearfix"><!-- #content start -->
		<div id="main" role="main" class="clearfix"><!-- #main start -->
			<article class="post" role="article" itemscope itemtype="http://schema.org/BlogPosting"><!-- .post start -->
				<header><!-- header start -->
					<h2 class="page-title" itemprop="headline">Neue Zutat</h2>
				</header><!-- header end -->
				<?php 
					include "infopanel.php";
										
					echo getIngredientAddForm();
				?>
			</article><!-- .post end -->
			
		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
	
	<script type="text/javascript">
	function chkFormular () {
	  var chkZ = 1;
	  for (i = 0; i < document.newIngForm.vol.value.length; ++i)
		if (document.newIngForm.vol.value.charAt(i) < "0" ||
			document.newIngForm.vol.value.charAt(i) > "9")
		  chkZ = -1;
	  if (chkZ == -1) {
		alert("Altersangabe keine Zahl!");
		document.newIngForm.vol.focus();
		return false;
	  }
	}
	</script>
	
</body>

</html>