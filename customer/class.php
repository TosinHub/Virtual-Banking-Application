<?php
function statement($conn, $id){

//$db = mysqli_connect ("localhost","root","","online_banking") or die(msqli_error($db));

	


	$query = mysqli_query($conn, "SELECT * FROM transaction 
					WHERE customer_id = '".$id."'") or die(mysqli_error());
 
	   $result = "";

	    while($row = mysqli_fetch_array($query)) {
       
	       $result .= "<tr>";

	        $result .= "<td>" .$row['transaction_date'].  "</td>";
	       $result  .=  "<td>". $row['transaction_type']. "</td>";
	       $result .= "<td>" .$row['sender']. "</td>";
	       $result .= "<td>" .$row['recipient'] ."</td>";
	       $result .="<td>" .$row['transfer_amount']."</td>";
	        $result .="<td>". $row['initial_balance']."</td>";
	       $result .="<td>" .$row['final_balance']. "</td>";
	        
	       $result .= "</tr>";

       }
       
       return $result;
}


