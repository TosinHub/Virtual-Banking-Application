<?php
	
	session_start();
	
	include('db/authentication.php');
	include ('class.php');

	authenticate();
	
	$admin_id = $_SESSION['id'];
	$admin_name =$_SESSION['admin_name'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Swap Space Bank - Home</title>
</head>

<body>

	<h3>Welcome!!!</h3>

	<?php 
	
	echo "<p>Admin ID: <strong>$admin_id</strong></p>";
	echo "<p>Admin Name: <strong>$admin_name</strong></p>";
	
	 ?>
     
     <hr/>
     
   <?php 
   $link = showLinks();
   echo "$link"; 

   ?>

</body>
</html>