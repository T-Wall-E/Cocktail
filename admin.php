<?php
/*
#	Author: Tobias Wallewein
#
#	�bersicht �ber den aktuell eingeloggten User
*/
	session_start();
	$title = "Verlauf";
	include_once "head.php";
	include_once "functions.php";
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link parent">Cocktail-Liste</a>
						<!-- New submenu level -->
					</li>

					<li><a href="/Cocktail/allocation.php" title="Belegung" class="link">Belegung</a>	
						<!-- New submenu level -->
					</li>
					
					<li><a href="/Cocktail/users.php" title="User-Liste" class="link">User-Liste</a>	
						<!-- New submenu level -->
					</li>
					
					<?php
						if(isset($_SESSION['UID']))
						{
							echo "<li>";
							echo 	"<a href='/Cocktail/user.php?uid=" . htmlspecialchars($_SESSION['UID']) ."' title='Dein Profil' class='link parent'>Dein Profil</a>";
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
									echo '<a href="/Cocktail/admin.php" title="Control-Panel" class="current">Control-Panel</a>';
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
					<h2 class="page-title" itemprop="headline">Control-Panel</h2>
				</header><!-- header end -->
				<?php
					echo "Hier entsteht die Admin-Seite";
				?>
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
	
</body>

</html>