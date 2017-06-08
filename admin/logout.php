<?php

	unset($_SESSION['id']);
	unset($_SESSION['admin_name']);
	
	header("Location:admin_login.php");

?>