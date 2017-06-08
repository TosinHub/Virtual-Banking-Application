<?php
	
	session_start();
	
	include('db/db.php');
	
	$name = $_SESSION['name'];
	$account_number = $_SESSION['account_number'];



	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Swap Space Bank - Customer Home</title>
</head>

<body>

	<h3>Customer Home </h3>

	<?php 
	
	echo "<p>Welcome dear <strong>".$name." </strong></p>";
	echo "<p>Account Number: $account_number </strong></p>";



	$select = mysqli_query($db, "SELECT account_balance FROM customer
														WHERE account_number = '".$account_number."' ") or die(mysqli_error($db));
	
	
	
				$result = mysqli_fetch_array($select);
				echo "<p>  Account Balance:" .$result['account_balance']. "</p>";


	 ?>
     
     <hr/>
     
     <a href="customer_home.php">Home</a>
     <a href="fund_transfer.php">Fund Transfer</a>
     <a href="statement.php">View Statement</a> 
     <a href="logout.php">Logout</a>

</body>
</html>