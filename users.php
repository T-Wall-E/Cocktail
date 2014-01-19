<?php 
	session_start();
	$title = "Cocktail-Liste";
	include_once "head.php";
	include_once "dbCon.php";
	
	function getUsers()
{
	$result = "";
	
	$sql = "SELECT *  FROM `users` ORDER BY ID";
	$sqlResult = mysql_query($sql);
	if (!$sqlResult) {
		die('Ungültige Anfrage: ' . $sql . ' - Gesamte Abfrage: '. mysql_error());
	}
	
	$result .= "<table>";
	
	$result .= "<thead>";
	$result .= "<tr>";
	$result .= "<th>";
	$result .= "ID";
	$result .= "</th>";
	$result .= "<th>";
	$result .= "Vorname";
	$result .= "</th>";
	$result .= "<th>";
	$result .= "Nachname";
	$result .= "</th>";
	$result .= "<th>";
	$result .= "Username";
	$result .= "</th>";
	$result .= "</tr>";
	$result .= "</thead>";
	
	$count = 1;
	$result .= "<tbody>";
	while($row = mysql_fetch_assoc($sqlResult))
	{
		$result .= "<tr>";
		$result .= "<td>";
		$result .= "<a href=user.php?uid=" . $row['ID'] . ">" . $row['ID'] . "</a>";
		$result .= "</td>";
		$result .= "<td>";
		$result .= $row['name'];
		$result .= "</td>";
		$result .= "<td>";
		$result .= $row['lastname'];
		$result .= "</td>";
		$result .= "<td>";
		$result .= $row['user'];
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
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="parent">Cocktail-Liste</a>
						
					</li>

					<li><a href="/Cocktail/allocation.php" title="Belegung" class="link">Belegung</a>	
						<!-- New submenu level -->
					</li>
					
					<li><a href="/Cocktail/users.php" title="User-Liste" class="current link">User-Liste</a>	
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
					<h2 class="page-title" itemprop="headline">User-Liste</h2>
				</header><!-- header end -->
				<?php 
				   if(isset($_SESSION['error']) && $_SESSION['error'] != null && $_SESSION['error'] != "")
				   {
					  echo "<div class='error'>" . $_SESSION['error'] . "</div>";
					  unset($_SESSION['error']);
				   }
					
					echo getUsers();
					
				?>
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
</body>

</html>
