<?php
if (isset($_POST['logout'])) {
    $_SESSION['user'] = null;
    session_destroy();
}
?>

<!doctype html>

<!-- 
Sunrise SilverStripe 3 CMS theme
Matt Bailey, GPMD http://www.gpmd.co.uk/
Version: 1.0.0
URL: http://www.gpmd.co.uk/
License: http://www.silverstripe.org/bsd-license/

Based on:

320 and Up boilerplate extension
Author: Andy Clarke (http://about.me/malarkey)
Author: Keith Clark (http://twitter.com/keithclarkcouk)
Version: 2
URL: http://stuffandnonsense.co.uk/projects/320andup/
License: http://creativecommons.org/licenses/MIT/
-->

<!--[if IEMobile 7]><html class="no-js iem7 oldie"><![endif]-->
<!--[if lt IE 7]><html class="no-js ie6 oldie" lang="de"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js ie7 oldie" lang="de"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js ie8 oldie" lang="de"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="de"><!--<![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html class="no-js" lang="de"><!--<![endif]-->

<head>		
	<title><?php $title ?></title>
	
	<!-- http://t.co/dKP3o1e -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0">
	
	<!--[if (lt IE 9) & (!IEMobile)]>
	<script src="sunrise-1.0.0/js/libs/selectivizr-min.js"></script>
	<![endif]-->
	
	<!-- JavaScript -->
	<script src="sunrise-1.0.0/js/libs/modernizr-2.0.6.min.js"></script>
	
	<!-- For iPhone 4 -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="sunrise-1.0.0/img/h/apple-touch-icon.png">
	<!-- For iPad 1-->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="sunrise-1.0.0/img/m/apple-touch-icon.png">
	<!-- For iPhone 3G, iPod Touch and Android -->
	<link rel="apple-touch-icon-precomposed" href="sunrise-1.0.0/img/l/apple-touch-icon-precomposed.png">
	<!-- For Nokia -->
	<link rel="shortcut icon" href="sunrise-1.0.0/img/l/apple-touch-icon.png">
	<!-- For everything else -->
	<link rel="shortcut icon" href="sunrise-1.0.0/favicon.ico">
	
	<!--iOS. Delete if not required -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="apple-touch-startup-image" href="sunrise-1.0.0/img/splash.png">
	
	<!--Microsoft. Delete if not required -->
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!--[if lt IE 7 ]><script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script><script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script><![endif]-->
	
	<!-- http://t.co/y1jPVnT -->
	<link rel="canonical" href="/">

	<!-- Load jQuery -->
	<script type="text/javascript" src="sunrise-1.0.0/js/libs/jquery.min.js"></script>
	<script type="text/javascript">
	if (typeof jQuery == 'undefined') {
		document.write(unescape("%3Cscript src='sunrise-1.0.0/js/libs/jquery-1.6.2.min.js' type='text/javascript'%3E%3C/script%3E"));
	}
	</script>

	<!-- Load CSS -->
	<link rel="stylesheet" type="text/css" href="sunrise-1.0.0/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="sunrise-1.0.0/css/typography.css" />
	<link rel="stylesheet" type="text/css" href="sunrise-1.0.0/css/form.css" />
	<link rel="stylesheet" type="text/css" href="sunrise-1.0.0/css/style.css" />
</head>