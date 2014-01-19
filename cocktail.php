<?php
	session_start();
	$title = "Cocktail-Details";
	include_once "head.php"
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link parent">Cocktail-Liste</a>
						<!-- New submenu level -->
							<?php
								$ulOpen = false;
								switch($_SESSION['GID'])
								{
									case 1:
									case 2:
										if(!$ulOpen)
										{
											echo "<ul>";
											$ulOpen=true;
										}
										echo "<li>";
										echo '<a href="/Cocktail/addCocktail.php" title="Neuer Cocktail" class="link">Neuer Cocktail</a>';
										echo "</li>";
										break;		
								}
								if(isset($_GET["id"]))
								{
									if(!$ulOpen)
									{
										echo "<ul>";
										$ulOpen=true;
									}
									echo "<li>";
									echo "<a href='/Cocktail/cocktail.php?id=" . htmlspecialchars($_GET["id"]) . "' title='Cocktail-Details' class='current'>Cocktail-Details</a>";
									echo "</li>";
								}
								
								if($ulOpen)
								{
									echo "</ul>";
									$ulOpen=true;
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
					<h2 class="page-title" itemprop="headline">Cocktail-Details</h2>
				</header><!-- header end -->
				<?php 
					if(isset($_SESSION['error']) && $_SESSION['error'] != null && $_SESSION['error'] != "")
					{
						echo "<div class='error'>" . $_SESSION['error'] . "</div>";
						unset($_SESSION['error']);
					}
					if(isset($_SESSION['success']) && $_SESSION['success'] != null && $_SESSION['success'] != "")
					{
						echo "<div class='success'>" . $_SESSION['success'] . "</div>";
						unset($_SESSION['success']);
					}
					
					include_once "cocktailmodel.php";
				?>
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>
</body>

</html>