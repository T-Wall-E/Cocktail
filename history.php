<?php
/*
#	Author: Tobias Wallewein
#
#	�bersicht �ber den aktuell eingeloggten User
*/
	session_start();
	$title = "Profil";
	include_once "head.php"
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
							echo 	"<a href='/Cocktail/user.php?uid=" . htmlspecialchars($_SESSION['UID']) ."' title='Dein Profil' class='link'>Dein Profil</a>";
							echo	"<a href='/Cocktail/history.php?uid=" . htmlspecialchars($_SESSION['UID']) . "' title='Verlauf' class='current'>Verlauf</a>";
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
					<h2 class="page-title" itemprop="headline">Verlauf</h2>
				</header><!-- header end -->
				<?php echo "Hier entsteht die History-seite die anzeigtm was f�r Cocktails du bereits probiert hast. ;)";?>
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