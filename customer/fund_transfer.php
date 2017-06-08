<?php
	
	session_start();
	
	include('db/db.php');
	
	$sender_customer_name = $_SESSION['name'];
	$account_number = $_SESSION['account_number'];



	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Swap Space Bank - Customer Home</title>
</head>

<body>
<?php 
	echo "<p>Welcome dear <strong>" .$sender_customer_name."</strong></p>";
	echo "<p>Account Number: $account_number </strong></p>";

	$query = mysqli_query($db, "SELECT account_balance FROM customer WHERE account_number = $account_number") or die(mysqli_error($db));
	$result = mysqli_fetch_array($query);
	$sender_account_balance = $result['account_balance'];

	echo "Account Balance: $sender_account_balance";
			
	?>

	<h3>Fund Transfer </h3>
	<p>Please enter your fund transfer details</p>

	<?php 

		if(array_key_exists('transfer', $_POST)){
			if(empty($_POST['rec_account']) || empty($_POST['transfer_amount'])){

					$error = "Fill all details";

					header("Location:fund_transfer.php?error=$error");

						} elseif (!is_numeric($_POST['transfer_amount'])) {

							$error = "Enter correct amount to be transfered";

							header("Location:fund_transfer.php?error=$error");
						}else{
							$transfer_amount = mysqli_real_escape_string($db, $_POST['transfer_amount']);
							$rec_account_number = mysqli_real_escape_string($db, $_POST['rec_account']);


							$query = mysqli_query($db, "SELECT customer_id,firstname,lastname,account_balance FROM customer WHERE account_number= '".$rec_account_number."'") or die(mysqli_error($db));

							if(mysqli_num_rows($query) == 1 ){
									$result = mysqli_fetch_array($query);
									$rec_customer_id = $result['customer_id'];
									$rec_customer_name = $result['firstname'].' '.$result['lastname'];;
									$rec_customer_acc_balance = $result['account_number'];


									if($transfer_amount > $sender_account_balance){
										$error = "Insufficient Fund, Try again!";
										header("Location: fund_transfer.php?error=$error");

									}else{

										$rec_new_account_balance = ($transfer_amount + $rec_customer_acc_balance);
										$sender_new_account_balance = ($sender_account_balance - $transfer_amount );

											#UPDATE SENDER DETAILS
											$sender_update = mysqli_query($db, "UPDATE customer SET account_balance = '".$sender_new_account_balance."' WHERE account_number = '".$account_number."'") or die(mysqli_error($db));

												#UPDATE RECIPIENT DETAILS

												$reciepient_update = mysqli_query($db, "UPDATE customer SET account_balance = '".$rec_new_account_balance."' WHERE account_number = '".$rec_account_number."'") or die(mysqli_error($db));

													#UPDATE THE TRANSACTION TABLE FOR SENDER

													$update_sender = mysqli_query($db, "INSERT INTO transaction 
														VALUES(NULL,
														NOW(),
														'DEBIT',
														'self',
														'".$rec_customer_name."',
														'".$transfer_amount."',
														'".$sender_account_balance."',
														'".$sender_new_account_balance."',
														'".$customer_id."')") or die(mysqli_error($db));
															#UPDATE THE TRANSACTION TABLE FOR RECIEVER

													$update_reciever = mysqli_query($db, "INSERT INTO transaction 
														VALUES(NULL,
														NOW(),
														'CREDIT',
														'".$sender_customer_name."',
														'self',
														'".$transfer_amount."',
														'".$rec_customer_acc_balance."',
														'".$rec_new_account_balance."',
														'".$rec_customer_id."')") or die(mysqli_error($db));

													$success = "Transaction successful";
													header("Location:fund_transfer.php?success=$success");


									}


							}
						}


		}
		if (isset($_GET['error'])) {
			echo "<p>" .$_GET['error']."</p>";}

			if (isset($_GET['success'])) {
			echo "<p>" .$_GET['success']."</p>";}


		?>

	<form method="post" action="">
	<p>Recipient Account: <input type="text" name="rec_account"/></p>		
	<p>Amount To Transfer: <input type="text" name="transfer_amount"/></p>	
	
	<input type="submit" name="transfer" value="Click to Transfer">

	</form>
	</body>
	</html>