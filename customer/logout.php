<?php

	unset($_SESSION['firstName']);
	unset($_SESSION['lastname']);
	unset($_SESSION['account_balance']);

	
	header("Location:customer_login.php");

?>