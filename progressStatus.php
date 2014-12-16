<?php
	session_start();
	$title = "Cocktail Progress-Test";
	include_once "functions.php";
	include_once "head.php";
	include_once "dbCon.php";
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
										echo '<a href="/Cocktail/editCocktail.php?id=' . htmlspecialchars($_GET['id']) . '" title="Cocktail bearbeiten">Cocktail bearbeiten</a>';
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
					<h2 class="page-title" itemprop="headline">Status-Seite</h2>
				</header><!-- header end -->
				<?php 
					include "infopanel.php";
					
					include "percent.php";
					$greatStatus=true;
				?>
			</article><!-- .post end -->
			

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
	
</body>

</html>