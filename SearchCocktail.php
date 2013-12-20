<?php 
	session_start();
	$title = "Cocktail-Suche";
	include_once "head.php";
	include_once "dbCon.php";
	include_once "functions.php";

//########### Funktionen ###############


	function getCocktails($searchStr)
	{
		$result = "";
		$table = "";
		
		$sql = "SELECT *  FROM `cocktails` WHERE name LIKE '%" . $searchStr . "%'";
		$sqlResult = mysql_query($sql);
		if (!$sqlResult) {
			die('Ungültige Anfrage: ' . $sql . ' - Gesamte Abfrage: '. mysql_error());
		}
		
		$table .= "<table border='1'>";
		$table .= "<th>";
		$table .= "Cocktail";
		$table .= "</th>";
		$table .= "<th>";
		$table .= "Verfügbar?";
		$table .= "</th>";
		
		$count = 0;
		while($row = mysql_fetch_assoc($sqlResult))
		{
			$count++;
			$table .= "<tr>";
			$table .= "<td>";
			$table .= "<a href=cocktail.php?id=" . $row['ID'] . ">" . $row['Name'] . "</a>";
			$table .= "</td>";
			$table .= "<td>";
			$table .= allIngredientsAvailable($row['ID']) ? "JA" : "NEIN";
			$table .= "</td>";
			$table .= "</tr>";
		}
		
		$table .= "</table>";
		
		if($count == 0)
		{
			$result = "Für deine Suchanfrage '". $searchStr ."' konnten keine Cocktails in der Datenbank gefunden werden!";
		}
		else
		{
			$result .= "<p>". $count ." Treffer </p>";
			$result .= $table;
		}
			
		
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
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link">Cocktail-Liste</a>
						<!-- New submenu level -->			
					</li>

					<li><a href="/Cocktail/allocation.php" title="Belegung" class="link">Belegung</a>	
						<!-- New submenu level -->
					</li>
					
					<li><a href="/Cocktail/user.php" title="Dein Profil" class="link">Dein Profil</a>	
						<!-- New submenu level -->
					</li>
			</ul>
		</nav><!-- #navigation end -->
	</header><!-- #header end -->
	
	<div id="content" class="clearfix"><!-- #content start -->
		<div id="main" role="main" class="clearfix"><!-- #main start -->
			<article class="post" role="article" itemscope itemtype="http://schema.org/BlogPosting"><!-- .post start -->
				<header><!-- header start -->
					<h3 class="page-title" itemprop="headline">Cocktail-Suche</h3>
				</header><!-- header end -->
				<?php 
					if(checkForSQLInjection($_GET['Search']))
					{
						echo "SQL-Injection festgestellt";
					}
					else
					{
						echo getCocktails($_GET['Search']);
					}
				?>
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
