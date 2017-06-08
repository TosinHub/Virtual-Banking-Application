<?php
	session_start();
    include ('db/db.php');
	
	include('class.php');
	
	$customer_id = $_SESSION['customer_id'];
	$customer_account_number = $_SESSION['account_number'];
	$customer_name = $_SESSION['name']
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
	
  
    
    <table>
    	<thead>
        	<th>Transaction Date</th><th>Type</th><th>Sender</th><th>Receiver</th>
            <th>Transaction Amount</th><th>Previous Balance</th><th>Final Balance</th>

            </thead>
         
        
        <?php 
       $statement = statement($db,$customer_id);
       echo $statement;
       ?>     
    
    </table>



<?php
    $query = mysqli_query($db, "SELECT * FROM transaction  WHERE customer_id = '".$customer_id."'
                     ORDER BY transaction_id DESC LIMIT 1
                    ") or die(mysqli_error());
    $row = mysqli_fetch_array($query);

        $final_balance = $row['final_balance'];

            echo $final_balance;
    
                         
    
    
    
?>


</body>
</html>