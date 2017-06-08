

<?php 


session_start();

include ('db/db_config.php');



?>



<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
</head>
<body>
<h1>Swap Space Bank</h1>
<h3>Welcome Admin</h3>
<p>Please enter your username and password</p>
<?php 

if(array_key_exists('login', $_POST)){

		$error  = array();

		if(empty($_POST['username'])){

			$error[] = "Enter Username";

		}else{
		$username = mysqli_real_escape_string($db, $_POST['username']);
			}

				if(empty($_POST['password'])){

			$error[] = "Enter Password";

		}else{
		$password = md5(mysqli_real_escape_string($db, $_POST['password']));
			}
				

					if(empty($error)){

						$query = mysqli_query ($db, "SELECT * FROM admin WHERE username = '".$username."'
													  AND
												 secured_password = '".$password."'") or die(mysqli_error($db));





												if(mysqli_num_rows($query) == 1){

														while ($admin_details = mysqli_fetch_array($query)) {
																$_SESSION['id'] = $admin_details['admin_id'];
																$_SESSION['admin_name'] = $admin_details['username'];

																header("Location:admin_home.php");
															}


															}	else{


																$login_error = "Invalid Username and/or Password";
																header("Location:admin_login.php?login_error=$login_error");
															}



													
										}

						else{
							foreach ($error as $error) {
								echo "<p> $error </p>";
								# code...
							}
						}	

}

if(isset($_GET['login_error'])){



	echo $_GET['login_error'];
}


?>



<form action="" method="post">
	<p>Username: <input type="text" name="username"/></p>
	<p>Password:<input type="password" name="password"></p>

	<input type="submit" name="login" value="Click to Login">


</form>
</body>
</html>