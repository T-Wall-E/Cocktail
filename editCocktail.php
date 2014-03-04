<?php
	session_start();
	$title = "Cocktail bearbeiten";
	include_once "functions.php";
	include_once "head.php";
	include_once "dbCon.php";
	
	if(isset($_POST['edit']))
    {
		$_SESSION['error'] = "";
		$_SESSION['success'] = "";
		
		checkForSQLInjectionWithRedirect($_POST['cid'], "index.php");
		$cid = $_POST['cid'];
		checkForSQLInjectionWithRedirect($_POST['name'], "editCocktail.php?id=" . $cid);
		checkForSQLInjectionWithRedirect($_POST['desc'], "editCocktail.php?id=" . $cid);
		checkForSQLInjectionWithRedirect($_POST['ingredients'], "editCocktail.php?id=" . $cid);
		checkForSQLInjectionWithRedirect($_POST['amounts'], "editCocktail.php?id=" . $cid);
		if(isset($_POST['ice']))
		{
			checkForSQLInjectionWithRedirect($_POST['ice'], "editCocktail.php?id=" . $cid);
		}
		checkForSQLInjectionWithRedirect($_POST['selectedImgInput'], "editCocktail.php?id=" . $cid);
		
		isValidNameWithRedirect($_POST['name'], "editCocktail.php?id=" . $cid);

		$name=$_POST['name'];
		$desc=$_POST['desc'];
		$img=$_POST['selectedImgInput'];
		$ingredients=$_POST['ingredients'];
		$amounts=$_POST['amounts'];
		$ice=0;
		if(isset($_POST['ice']))
		{
			$ice=$_POST['ice'];
		}
		
		
		$errors = array();
		
		$sqlInsertCocktail = "UPDATE cocktails " .
							" SET" . 
							" Name='" . $name . "', " .
							" Description='" . $desc . "', " .
							" ImageURL='" . $img . "', " .
							" ice=";
							if($ice == 1)
							{
								$sqlInsertCocktail .= "TRUE";
							}
							else
							{
								$sqlInsertCocktail .= "FALSE";
							}
							$sqlInsertCocktail .= " WHERE id = " . $cid;
		$resultInsertCocktail = mysql_query($sqlInsertCocktail);
		if(!$resultInsertCocktail)
		{
			$errors[]  = mysql_error();			
		}
		
		if(count($errors) > 0)
        {
			$_SESSION['error'] = concatArr($errors);
			header("location: editCocktail.php?id=" . $cid);
		}
				
		$sqlDeleteRecipe = "DELETE FROM recipes WHERE CID = " . $cid;
		$resultDeleteRecipe = mysql_query($sqlDeleteRecipe);
		if(!$resultDeleteRecipe)
		{
			$errors[]  = mysql_error();
			$errors[]  = $sqlDeleteRecipe;
			if(count($errors) > 0)
			{
				$_SESSION['error'] = concatArr($errors);
				header("location: editCocktail.php?id=" . $cid);
			}
		}
		
		for($i = 0; $i < count($ingredients); $i++)
		{
			$sqlInsertRecipe = "INSERT INTO recipes (amount, CID, IID) " .
							"VALUES (" . $amounts[$i] . ", " . $cid .
							", " . $ingredients[$i] . ")";
			$resultInsertRecipe = mysql_query($sqlInsertRecipe);
			if(!$resultInsertRecipe)
			{
				$errors[]  = mysql_error();
				$errors[]  = $sqlInsertRecipe;
				if(count($errors) > 0)
				{
					$_SESSION['error'] = concatArr($errors);
					header("location: editCocktail.php?id=" . $cid);
				}
			}
		}
		
		if(count($errors) > 0)
        {
			$_SESSION['error'] = concatArr($errors);
			header("location: editCocktail.php?id=" . $cid);
		}
		
		$_SESSION['success'] = $name . " wurde erfolgreich geändert!";
		session_write_close();
		header("location: cocktail.php?id=" . $cid);
	}
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one <?php echo isAdminBy_SESSION() ? "level-two" : "" ?>">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link parent">Cocktail-Liste</a>
						<!-- New submenu level -->
							<?php
								if(isAdminBy_SESSION())
								{
									echo "<ul>";
									echo "<li>";
									echo '<a href="/Cocktail/addCocktail.php" title="Neuer Cocktail" class="link">Neuer Cocktail</a>';
									echo "</li>";
									if(isset($cid))
									{
										echo "<li>";
										echo '<a href="/Cocktail/editCocktail.php?id=' . htmlspecialchars($_GET['id']) . '" title="Cocktail bearbeiten" class="current">Cocktail bearbeiten</a>';
										echo "</li>";
									}
									echo "</ul>";
								}
							?>
					</li>
					
					<li><a href="/Cocktail/ingredients.php" title="Zutaten-Liste" class="link <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Zutaten-Liste</a>
						
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
					<h2 class="page-title" itemprop="headline">Cocktail bearbeiten</h2>
				</header><!-- header end -->
				<?php 
					include "infopanel.php";
					
					$cocktail = getCocktail($_GET['id']);					
					
					$form = "<form action='editCocktail.php?id=" . $cocktail['ID'] . "' method='POST'>";
					$form .= "<input type='hidden' name='cid' value='" . $cocktail['ID'] . "' />";
					$form .= "<table>";
					$form .= "<tbody>";
					
					$form .= "<tr>";
					$form .= "<td>";
					$form .= "Name";
					$form .= "</td>";
					$form .= "<td>";
					$form .= "<input type='text' name='name' value='" . $cocktail['Name'] . "' />";
					$form .= "</td>";
					$form .= "</tr>";
					
					$form .= "<tr>";
					$form .= "<td>";
					$form .= "Beschreibung";
					$form .= "</td>";
					$form .= "<td>";
					$form .= "<textarea name='desc'>" . $cocktail['Description'] . "</textarea>";
					$form .= "</td>";
					$form .= "</tr>";
					$form .= "</tbody>";
					$form .= "</table>";
					
					$form .= "<h3>Bild wählen</h3>";
					$dir    = 'images';
					$files = array_diff(scandir($dir), array('..', '.'));
					$form .= "<div style='overflow: auto; width:100%; height:200px;'>";
					foreach ($files as $value)
					{
							$form .= '<img class="clickableimg" id="'.$value.'" src="'. $dir . '/' .$value.'" />';
					}
					$form .= "</div>";
					$form .= "<table id='smalltable'>";
					$form .=  "<tr>";
					$form .=  "<td>";
					$form .=  "Gewähltes Bild:";
					$form .=  "</td>";
					$form .=  "<td>";
					$form .= "<img id='selectedImg' src='" . $cocktail['ImageURL'] . "' alt='" . $cocktail['ImageURL'] . "'>";
					$form .= "<input type='hidden' id='selectedImgInput' name='selectedImgInput' value='" . $cocktail['ImageURL'] . "' />";
					$form .=  "</td>";
					$form .=  "</tr>";
					$form .= "</table>";
					
					$form .= "<h3>Zutaten</h3>";
					$form .= "<p>";
					$form .= 	"<input type='button' value='Weitere Zutat' onClick='addRow(\"tableIngridient\")' /> ";
					$form .= 	"<input type='button' value='Zutat(en) entfernen' onClick='deleteRow(\"tableIngridient\")' title='(Betrifft nur die angehakten Zutaten)'/>";
					$form .= "</p>";
					$form .= "<table id='tableIngridient'>";
					$form .= "<tbody>";
					$recipe = getRecipe($_GET['id']);
					foreach($recipe as $ing)
					{
						$form .= "<tr>";
						$form .= "<td >";
						$form .= "<input type='checkbox' name='chk[]' checked='checked' />";
						$form .= "</td>";
						$form .= "<td>";
						$form .= "<input type='number' name='amounts[]' min='1' max='250' value='" . $ing["amount"] . "'/>";
						$form .= "</td>";
						$form .= "<td>";
						$form .= getIngredientsCombobox($ing['ingID']);
						$form .= "</td>";
						$form .= "</tr>";
					}
					$form .= "</tbody>";
					$form .= "</table>";
					
					$form .= "<input type='checkbox' name='ice' value='1'" . (($cocktail['ice']) ? ("checked='checked'") : ("")) . "> mit Eis (noch wird diese Auswahl nicht berücksichtigt!!!)</input>";
					$form .= "</br>";
					$form .= "</br>";
					
					$form .= "<input type='submit' name='edit' value='Cocktail speichern' />";
					$form .= "</form>";
					
					echo $form;
				?>
			</article><!-- .post end -->
			
			<script>
			jQuery(".clickableimg").click(function() {
				var choosenpic = jQuery(this).attr('id');
				var newPic = <?php echo '"'. $dir . '/"'; ?> + choosenpic;
				jQuery("#selectedImgInput").val(newPic);
				jQuery("#selectedImg").attr("src", newPic);
				jQuery("#selectedImg").attr("alt", newPic);
			});
			
			function addRow(tableID) {
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;
				if(rowCount < 8){                            // limit the user from creating fields more than your limits
					var row = table.insertRow(rowCount);
					var colCount = table.rows[0].cells.length;
					for(var i=0; i<colCount; i++) {
						var newcell = row.insertCell(i);
						newcell.innerHTML = table.rows[0].cells[i].innerHTML;
					}
				}else{
					 alert("Mehr Zutatuen gehen nicht!");
						   
				}
			}

			function deleteRow(tableID) {
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;
				for(var i=0; i<rowCount; i++) {
					var row = table.rows[i];
					var chkbox = row.cells[0].childNodes[0];
					if(null != chkbox && true == chkbox.checked) {
						if(rowCount <= 1) {               // limit the user from removing all the fields
							alert("Mann brauch mindestens 2 Zutaten für einen Cocktail.");
							break;
						}
						table.deleteRow(i);
						rowCount--;
						i--;
					}
				}
			}
			</script>

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
	
</body>

</html>