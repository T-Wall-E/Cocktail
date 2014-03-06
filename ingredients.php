<?php 
	session_start();
	$title = "Zutaten-Liste";
	include_once "head.php";
	include_once "functions.php";
	include_once "dbCon.php";
	
	function getIngredients()
	{
		$result = "";
		
		$sql = "SELECT i.name AS zutat, i.ID AS ID, i.vol AS vol, u.name AS einheit, u.token AS token FROM `ingredients` i JOIN `units` u ON i.UID = u.ID ORDER BY i.name";
		$sqlResult = mysql_query($sql);
		if (!$sqlResult) {
			die('Ungültige Anfrage: ' . $sql . ' - Gesamte Abfrage: '. mysql_error());
		}
		
		$result .= "<table>";
		
		$result .= "<thead>";
		$result .= "<tr>";
		$result .= "<th>";
		$result .= "#";
		$result .= "</th>";
		$result .= "<th>";
		$result .= "Zutat";
		$result .= "</th>";
		$result .= "<th>";
		$result .= "Einheit";
		$result .= "</th>";
		$result .= "<th>";
		$result .= "Volumenprozent";
		$result .= "</th>";
		$result .= "<th>";
		$result .= "löschen?";
		$result .= "</th>";
		$result .= "</tr>";
		$result .= "</thead>";
		
		$count = 1;
		$result .= "<tbody>";
		
		while($row = mysql_fetch_assoc($sqlResult))
		{
			$result .= "<tr>";
			$result .= "<td>";
			$result .= $count++;
			$result .= "</td>";
			$result .= "<td>";
			$result .= $row['zutat'];
			$result .= "</td>";
			$result .= "<td>";
			$result .= $row['einheit'] . " (" . $row['token'] . ")";
			$result .= "</td>";
			$result .= "<td>";
			if($row['vol'] > 0)
			{
				$result .= $row['vol'] . " Vol.-%";
			}
			$result .= "</td>";
			$result .= "<td>";
			$result .= "<a href=deleteIngredient.php?id=" . $row['ID'] . ">Löschen</a>";
			$result .= "</td>";
			$result .= "</tr>";
		}
		
		$result .= "</tbody>";
		
		$result .= "</table>";
		
		return $result;
	}
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php
			include_once "innerheader.php";
		?>

		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one <?php echo isAdminBy_SESSION() ? "level-two" : "" ?>">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Cocktail-Liste</a>

					</li>
					
					<li><a href="/Cocktail/ingredients.php" title="Zutaten-Liste" class="current <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Zutaten-Liste</a>
						<?php
							if(isAdminBy_SESSION())
							{
								echo "<ul>";
								echo "<li>";
								echo '<a href="/Cocktail/addIngredient.php" title="Neue Zutat" class="link">Neue Zutat</a>';
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
					<h2 class="page-title" itemprop="headline">Zutaten-Liste</h2>
				</header><!-- header end -->
				<?php 
				   include "infopanel.php";
				   
				   echo getIngredients();
				?>
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
</body>

</html>
