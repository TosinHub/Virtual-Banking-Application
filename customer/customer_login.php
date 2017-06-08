

<?php 


session_start();
include('db/db.php');
include ('class.php');




?>



<!DOCTYPE html>
<html>
<head>
	<title>Customer Login</title>
</head>
<body>
<h1>Swap Space Bank</h1>
<h3>Welcome to our online Banking Application</h3>
<p>Please enter your Account Number and password</p>
<?php 

if(array_key_exists('login', $_POST)){

		$error  = array();

		if(empty($_POST['account_no'])){

			$error[] = "Enter correct account number";

		}else{
		$account_no = mysqli_real_escape_string($db, $_POST['account_no']);
			}

				if(empty($_POST['password'])){

			$error[] = "Enter Password";

		}else{
		$password = md5(mysqli_real_escape_string($db, $_POST['password']));
			}
				

					if(empty($error)){

						$query = mysqli_query ($db, "SELECT * FROM customer WHERE account_number = '".$account_no."'
													  AND
												 password = '".$password."'") or die(mysqli_error($db));





												if(mysqli_num_rows($query) == 1){ 

												while ($customer_details = mysqli_fetch_array($query)) {
												$_SESSION['name'] = $customer_details['firstname'] .' '.$customer_details['lastname'];
														
												$_SESSION['account_number'] = $customer_details['account_number'];
												$_SESSION['customer_id'] = $customer_details['customer_id'];
															

																header("Location:customer_home.php");
															}


															}	else{


																$login_error = "Invalid Username and/or Password";
																header("Location:customer_login.php?login_error=$login_error");
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
	<p>Account No: <input type="text" name="account_no"/></p>
	<p>Password:<input type="password" name="password"></p>

	<input type="submit" name="login" value="Click to Login">


</form>
</body>
</html>