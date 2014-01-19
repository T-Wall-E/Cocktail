<?php 
	session_start();
	$title = "Cocktail-Liste";
	include_once "head.php"
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php
			include_once "innerheader.php";
		?>

		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="current parent">Cocktail-Liste</a>
						<?php
							if(isset($_SESSION['GID']))
							{
								switch($_SESSION['GID'])
								{
									case 1:
									case 2:
										echo "<ul>";
										echo "<li>";
										echo '<a href="/Cocktail/addCocktail.php" title="Neuer Cocktail" class="link">Neuer Cocktail</a>';
										echo "</li>";
										echo "</ul>";
										break;		
								}
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
					<h2 class="page-title" itemprop="headline">Cocktail-Liste</h2>
				</header><!-- header end -->
				<?php 
				   if(isset($_SESSION['error']) && $_SESSION['error'] != null && $_SESSION['error'] != "")
				   {
					  echo "<div class='error'>" . $_SESSION['error'] . "</div>";
					  unset($_SESSION['error']);
				   }
					if (isset($_SESSION['user']) && $_SESSION['user'] != null && $_SESSION['user'] != "" && isset($_SESSION['UID']))
					{
						include_once "cocktaillist.php";
					}
					else
					{
						include_once "login.php";
					}
				?>
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
</body>

</html>
