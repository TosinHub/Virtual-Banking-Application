<?php 


session_start();

include('db/authentication.php');
include('class.php');

	authenticate();
$admin_id = $_SESSION['id'];
	$admin_name =$_SESSION['admin_name'];


?>


<!DOCTYPE html>
<html>
<head>
	<title>Add Customers</title>
</head>
<body>

<?php 
	
	echo "<p>Admin ID: <strong>$admin_id</strong></p>";
	echo "<p>Admin Name: <strong>$admin_name</strong></p>";
	
	 ?>
     
     <hr/>
<hr/>

     
   <?php 
   $link = showLinks();
   echo "$link"; 

   ?>
<hr/>

<?php 
if(array_key_exists('add', $_POST)){

	$error = array();
	if(empty($_POST['fname']))
	{
		$error[] = "Enter FirstName";
	}else
	{
		$fname = mysqli_real_escape_string($db, $_POST['fname']);
	}
	if(empty($_POST['lname']))
	{
		$error[] = "Enter Last Name";
	}else
	{
		$lname = mysqli_real_escape_string($db, $_POST['lname']);
	}
	if(empty($_POST['email']))
	{
		$error[] = "Enter Email";
	}else
	{
		$email = mysqli_real_escape_string($db, $_POST['email']);
	}
	if(empty($_POST['phone']))
	{
		$error[] = "Enter Phone Number";
	}else
	{
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
	}
	if(empty($_POST['account_type']))
	{
		$error[] = "Enter Account Type";
	}else
	{
		$account_type = mysqli_real_escape_string($db, $_POST['account_type']);
	}
	if(empty($_POST['opening_balance']))
	{
		$error[] = "Enter Opening Balance";
	}elseif (!is_numeric($_POST['opening_balance'])) {
		$error[] = "Enter a valid opening balance";
	}
	else
	{
		$opening_balance = mysqli_real_escape_string($db, $_POST['opening_balance']);
	}
	if(empty($_POST['password']))
	{
		$error[] = "Enter Customer's Password";
	}else
	{
		$password = md5(mysqli_real_escape_string($db, $_POST['password']));
	}
  			



  	if(empty($error)){

      $query = mysqli_query($db, "INSERT INTO customer VALUES 
                                    (NULL,
                                    '".$fname."', 
                                    '".$lname."',
                                    '".$email."',
                                    '".$phone."',
                                    '".$account_type."',
                                    '".$opening_balance."',
                                     '".$opening_balance."',
                                      '".rand(1000000000,9999999999)."',
                                   '".$password."', 
                                    '".$admin_id."'  )   
                                    ") or die(mysqli_error($db));
      $success = "Customer Successfully Added";
				
				header("Location:add_customers.php?success=$success");


  			}else{


  					foreach ($error as $error) {
  						# code...
  					
  				echo "<p> $error</p>";
  						}


  			}


}



if(isset($_GET['success'])){
	
	echo '<p><em>'.$_GET['success'].'</em></p>';	
	}


?>


<form action="" method="post">
	<p>FirstName: <input type="text" name="fname"/></p>
	<p>Lastname <input type="text" name="lname"/></p>
	<p>Email: <input type="text" name="email"></p>
	<p>Phone Number:<input type="text" name="phone"/></p>
	<p>Account Type: <select name="account_type">
						<option value=""> Select Account Type</option>

<?php 
$account_type = array("Savings", "Corporate", "Current","Domiciliary");

foreach ($account_type as $account_type) {
	# code...
?>
<option value="<?php echo "$account_type"; ?>"><?php echo "$account_type"; ?></option>
<?php } ?>

	</select></p>
<p>Opening Balance: <input type="text" name="opening_balance"/></p>
<p>Password:<input type="text" name="password"/></p>

<input type="submit" name="add" value="Click to Add"/>



</form>
</body>
</html>