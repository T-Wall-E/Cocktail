<?php 
	session_start();
	$title = "Impressum";
	include_once "head.php";
?>

<body class="clearfix">

	<header role="banner" id="header"><!-- #header start -->
	
		<?php include_once "innerheader.php"; ?>
		
		<!-- navigation -->
		<nav role="navigation" id="navigation" class="clearfix"><!-- #navigation start -->
			<ul class="level-one">
					<li><a href="/Cocktail/index.php" title="Cocktail-Liste" class="link <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Cocktail-Liste</a>
						<!-- New submenu level -->			
					</li>
					
					<li><a href="/Cocktail/ingredients.php" title="Zutaten-Liste" class="link <?php echo isAdminBy_SESSION() ? "parent" : "" ?>">Zutaten-Liste</a>
						
					</li>

					<li><a href="/Cocktail/allocation.php" title="Belegung" class="current">Belegung</a>	
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
					<h2 class="page-title" itemprop="headline">Impressum</h2>
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
				?>
				
				<h2>Verantwortlich f�r den Inhalt dieser Webseite:</h2>

				<p>
				Max Mustermann </br>
				Beispielweg 99 </br>
				12345 Musterhausen </br>
				name@email.de </br>
				www.webseite.de </br>
				</p>


				<h2>Haftungsausschluss</h2>

				<h3>1. Inhalt des Onlineangebotes</h3>
				<p>
				Der Autor �bernimmt keinerlei Gew�hr f�r die Aktualit�t, Korrektheit, Vollst�ndigkeit oder Qualit�t der bereitgestellten Informationen. Haftungsanspr�che gegen den Autor, welche sich auf Sch�den materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen bzw. durch die Nutzung fehlerhafter und unvollst�ndiger Informationen verursacht wurden, sind grunds�tzlich ausgeschlossen, sofern seitens des Autors kein nachweislich vors�tzliches oder grob fahrl�ssiges Verschulden vorliegt. 
				Alle Angebote sind freibleibend und unverbindlich. Der Autor beh�lt es sich ausdr�cklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ank�ndigung zu ver�ndern, zu erg�nzen, zu l�schen oder die Ver�ffentlichung zeitweise oder endg�ltig einzustellen. 
				</p>
				
				<h3>2. Verweise und Links</h3>
				
				<p>Bei direkten oder indirekten Verweisen auf fremde Webseiten (Hyperlinks), die au�erhalb des Verantwortungsbereiches des Autors liegen, w�rde eine Haftungsverpflichtung ausschlie�lich in dem Fall in Kraft treten, in dem der Autor von den Inhalten Kenntnis hat und es ihm technisch m�glich und zumutbar w�re, die Nutzung im Falle rechtswidriger Inhalte zu verhindern. 
				Der Autor erkl�rt hiermit ausdr�cklich, dass zum Zeitpunkt der Linksetzung keine illegalen Inhalte auf den zu verlinkenden Seiten erkennbar waren. Auf die aktuelle und zuk�nftige Gestaltung, die Inhalte oder die Urheberschaft der verlinkten/verkn�pften Seiten hat der Autor keinerlei Einfluss. Deshalb distanziert er sich hiermit ausdr�cklich von allen Inhalten aller verlinkten /verkn�pften Seiten, die nach der Linksetzung ver�ndert wurden. Diese Feststellung gilt f�r alle innerhalb des eigenen Internetangebotes gesetzten Links und Verweise sowie f�r Fremdeintr�ge in vom Autor eingerichteten G�steb�chern, Diskussionsforen, Linkverzeichnissen, Mailinglisten und in allen anderen Formen von Datenbanken, auf deren Inhalt externe Schreibzugriffe m�glich sind. F�r illegale, fehlerhafte oder unvollst�ndige Inhalte und insbesondere f�r Sch�den, die aus der Nutzung oder Nichtnutzung solcherart dargebotener Informationen entstehen, haftet allein der Anbieter der Seite, auf welche verwiesen wurde, nicht derjenige, der �ber Links auf die jeweilige Ver�ffentlichung lediglich verweist. 
				</p>
				
				<h3>3. Urheber- und Kennzeichenrecht</h3> 
				<p>
				Der Autor ist bestrebt, in allen Publikationen die Urheberrechte der verwendeten Grafiken, Tondokumente, Videosequenzen und Texte zu beachten, von ihm selbst erstellte Grafiken, Tondokumente, Videosequenzen und Texte zu nutzen oder auf lizenzfreie Grafiken, Tondokumente, Videosequenzen und Texte zur�ckzugreifen. 
				Alle innerhalb des Internetangebotes genannten und ggf. durch Dritte gesch�tzten Marken- und Warenzeichen unterliegen uneingeschr�nkt den Bestimmungen des jeweils g�ltigen Kennzeichenrechts und den Besitzrechten der jeweiligen eingetragenen Eigent�mer. Allein aufgrund der blo�en Nennung ist nicht der Schluss zu ziehen, dass Markenzeichen nicht durch Rechte Dritter gesch�tzt sind! 
				Das Copyright f�r ver�ffentlichte, vom Autor selbst erstellte Objekte bleibt allein beim Autor der Seiten. Eine Vervielf�ltigung oder Verwendung solcher Grafiken, Tondokumente, Videosequenzen und Texte in anderen elektronischen oder gedruckten Publikationen ist ohne ausdr�ckliche Zustimmung des Autors nicht gestattet. 
				</p>
				
				<h3>4. Datenschutz</h3>
				<p>
				Sofern innerhalb des Internetangebotes die M�glichkeit zur Eingabe pers�nlicher oder gesch�ftlicher Daten (Emailadressen, Namen, Anschriften) besteht, so erfolgt die Preisgabe dieser Daten seitens des Nutzers auf ausdr�cklich freiwilliger Basis. Die Inanspruchnahme und Bezahlung aller angebotenen Dienste ist - soweit technisch m�glich und zumutbar - auch ohne Angabe solcher Daten bzw. unter Angabe anonymisierter Daten oder eines Pseudonyms gestattet. Die Nutzung der im Rahmen des Impressums oder vergleichbarer Angaben ver�ffentlichten Kontaktdaten wie Postanschriften, Telefon- und Faxnummern sowie Emailadressen durch Dritte zur �bersendung von nicht ausdr�cklich angeforderten Informationen ist nicht gestattet. Rechtliche Schritte gegen die Versender von sogenannten Spam-Mails bei Verst�ssen gegen dieses Verbot sind ausdr�cklich vorbehalten. 
				</p>
				
				<h3>5. Rechtswirksamkeit dieses Haftungsausschlusses</h3> 
				<p>
				Dieser Haftungsausschluss ist als Teil des Internetangebotes zu betrachten, von dem aus auf diese Seite verwiesen wurde. Sofern Teile oder einzelne Formulierungen dieses Textes der geltenden Rechtslage nicht, nicht mehr oder nicht vollst�ndig entsprechen sollten, bleiben die �brigen Teile des Dokumentes in ihrem Inhalt und ihrer G�ltigkeit davon unber�hrt. 
				</p>
				

				<h2>Disclaimer</h2>

				<h3>1. Content</h3> 
				<p>
				The author reserves the right not to be responsible for the topicality, correctness, completeness or quality of the information provided. Liability claims regarding damage caused by the use of any information provided, including any kind of information which is incomplete or incorrect,will therefore be rejected. 
				All offers are not-binding and without obligation. Parts of the pages or the complete publication including all offers and information might be extended, changed or partly or completely deleted by the author without separate announcement.
				</p>
				
				<h3>2. Referrals and links</h3>
				<p>
				The author is not responsible for any contents linked or referred to from his pages - unless he has full knowledge of illegal contents and would be able to prevent the visitors of his site fromviewing those pages. If any damage occurs by the use of information presented there, only the author of the respective pages might be liable, not the one who has linked to these pages. Furthermore the author is not liable for any postings or messages published by users of discussion boards, guestbooks or mailinglists provided on his page. 
				</p>
				
				<h3>3. Copyright</h3>
				<p>
				The author intended not to use any copyrighted material for the publication or, if not possible, to indicatethe copyright of the respective object. 
				The copyright for any material created by the author is reserved. Any duplication or use of objects such as diagrams, sounds or texts in other electronic or printed publications is not permitted without the author's agreement. 
				</p>
				
				<h3>4. Privacy policy</h3> 
				<p>
				If the opportunity for the input of personal or business data (email addresses, name, addresses) is given, the input of these data takes place voluntarily. The use and payment of all offered services are permitted - if and so far technically possible and reasonable - without specification of any personal data or under specification of anonymized data or an alias. The use of published postal addresses, telephone or fax numbers and email addresses for marketing purposes is prohibited, offenders sending unwanted spam messages will be punished. 
				</p>
				
				<h3>5. Legal validity of this disclaimer</h3>
				<p>
				This disclaimer is to be regarded as part of the internet publication which you were referred from. If sections or individual terms of this statement are not legal or correct, the content or validity of the other parts remain uninfluenced by this fact. 
				</p>	
				
			</article><!-- .post end -->

		</div><!-- #main end -->
	</div><!-- .content end -->
	
	<?php include_once "footer.php" ?>

</body>

</html>