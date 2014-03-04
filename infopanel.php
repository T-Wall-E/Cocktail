<?php
	if(isset($_SESSION['info']) && $_SESSION['info'] != null && $_SESSION['info'] != "")
	{
		echo "<div class='info'>" . $_SESSION['info'] . "</div>";
		unset($_SESSION['info']);
	}
	if(isset($_SESSION['success']) && $_SESSION['success'] != null && $_SESSION['success'] != "")
	{
		echo "<div class='success'>" . $_SESSION['success'] . "</div>";
		unset($_SESSION['success']);
	}
	if(isset($_SESSION['error']) && $_SESSION['error'] != null && $_SESSION['error'] != "")
	{
		echo "<div class='error'>" . $_SESSION['error'] . "</div>";
		unset($_SESSION['error']);
	}
?>