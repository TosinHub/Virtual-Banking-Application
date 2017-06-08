<?php
	session_start();
	
	include('db/db.php');
	
	$customer_id = $_SESSION['customer_id'];
	$customer_account_number = $_SESSION['account_number'];
	$customer_name = $_SESSION['name'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funds Transfer</title>
</head>

<body>
	
    <h2>Welcome Home</h2>
    
    <?php 
	echo "<p>Customer ID: <strong>".$customer_id."</strong></p>";
	echo "<p>Customer Name: <strong>".$customer_name."</strong></p>";
	echo "<p>Customer Account Number: <strong>".$customer_account_number."</strong></p>";
	
	?>
    
    
    <hr/>
    
    <a href="customer_home.php">Home</a>
    <a href="transaction.php">Funds Transfer</a>
    <a href="statement.php">Account Statement</a>
    <a href="logout.php">Click to Logout</a>
    <hr/>
    
    <?php
	
	//HERE WE WRITE A QUERY TO SELECT THE SENDER'S ACCOUNT BALANCE
	$query = mysqli_query($db, "SELECT account_balance FROM customer WHERE 
	                          account_number = '".$customer_account_number."'") or
							  die(mysqli_error($db));
							  
		$result = mysqli_fetch_array($query);
		
		$sender_acc_balance = $result['account_balance'];
		
	
	?>
    
    

	<h2>Funds Transfer Page</h2>
    
    <?php echo "<h3>Account Balance: ".$sender_acc_balance."</h3>" ?>
    
    
    <?php
	
		if(array_key_exists('transfer', $_POST)){
		
			if(empty($_POST['rec_acc_num']) || empty($_POST['amount']) ) {
				$msg = "Some fields are missing";
				header("Location:transaction.php?msg=$msg");	
			} elseif(!is_numeric($_POST['amount'])) { //IF AMOUNT IS NOT NUMERIC
				$msg = "Please enter a correct value for amount";
				header("Location:transaction.php?msg=$msg");
			} elseif($_POST['rec_acc_num'] == $customer_account_number){
				$msg = "Ogbeni, be careful ooo";
				header("Location:transaction.php?msg=$msg");	
			} else {
			
		$recipient_acc_num = mysqli_real_escape_string($db, $_POST['rec_acc_num']);
		$transfer_amount = mysqli_real_escape_string($db, $_POST['amount']);
		
		
		//HERE, WE SELECT RECIPIENT"S DETAILS FROM THE CUSTOMER TABLE
		
	$query = mysqli_query($db, "SELECT customer_id, firstname, lastname,
	 		                 account_balance FROM customer WHERE
							 account_number = '".$recipient_acc_num."'") or 
							 die(mysqli_error());
							 
	if(mysqli_num_rows($query) == 1){
		
	$recipient = mysqli_fetch_array($query);
	
	$recipient_customer_id = $recipient['customer_id'];
	$recipient_name = $recipient['firstname'].' '.$recipient['lastname'];
	$recipient_current_balance = $recipient['account_balance'];
	
	
	//HERE WE PERFORM THE MATHEMATICAL TRANSACTION
	
		 if($sender_acc_balance < $transfer_amount) {
			
			$msg = "Insufficient Funds. Operations Failed";
			header("Location:transaction_php?msg=$msg"); 
		 } else {
			
			$sender_new_balance = ($sender_acc_balance - $transfer_amount);
			$recipient_new_balance = ($transfer_amount + $recipient_current_balance);
			
			
	//WE UPDATE THE SENDER'S ACCOUNT BALANCE
	
	$sender_update = mysqli_query($db, "UPDATE customer SET 
									   account_balance = '".$sender_new_balance."'
				WHERE account_number = '".$customer_account_number."'") or 
				die(mysqli_error());
				
  //WE UPDATE THE RECEIVER'S ACCOUNT BALANCE
  
  $recipient_update = mysqli_query($db, "UPDATE customer SET
  								account_balance = '".$recipient_new_balance."'
								WHERE account_number = '".$recipient_acc_num."'")
								or die(mysqli_error());
								
	//WE INSERT FOR SENDER
	
	$sender_insert = mysqli_query($db, "INSERT INTO transaction
										VALUES(NULL,
										NOW(),
										'debit',
										'self',
										'".$recipient_name."',
										'".$transfer_amount."',
										'".$sender_acc_balance."',
										'".$sender_new_balance."',
										'".$customer_id."')") or die(mysqli_error());
										
	$recipient_insert = mysqli_query($db, "INSERT INTO transaction
										  VALUES(NULL,
										  NOW(),
										  'credit',
										  '".$customer_name."',
										  'self',
										  '".$transfer_amount."',
										  '".$recipient_current_balance."',
										  '".$recipient_new_balance."',
										  '".$recipient_customer_id."')")
										  
										  or die(mysqli_error());
										  
				$success = "Transaction Successful";
				header("Location:transaction.php?success=$success");	 
		 }
		
	} else { //IF IT IS NOT EQUAL TO 1
			
			$msg = "Operations Failed. Please Try again";
			header("Location:transaction.php?msg=$msg");	
		}
				
	}
		
} //END OF MAIN IF
	
	
	if(isset($_GET['msg'])){
	echo '<p>'.$_GET['msg'].'</p>';	
	}
	
	if(isset($_GET['success'])){
	echo '<h3><em>'.$_GET['success'].'</em></h3>';	
	}
	
	?>
    
    <form action="" method="post">
    	<p>Enter Recipient Account Number: <input type="text" name="rec_acc_num"/></p>
        <p>Enter Amount to be transfered: <input type="text" name="amount"/></p>
        
        <input type="submit" name="transfer" value="Click to Transfer"/>
    
    </form>


</body>
</html>