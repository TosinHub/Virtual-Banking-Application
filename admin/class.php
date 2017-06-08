<?php
function viewCustomer($conn){

//$db = mysqli_connect ("localhost","root","","online_banking") or die(msqli_error($db));

	

 $select = mysqli_query($conn, "SELECT * FROM customer") or die(mysqli_error($db)); 
 
	   $result = "";

	    while($row = mysqli_fetch_array($select)) {
       
	       $result .= "<tr>";

	       $result .= "<td>" .$row['firstname'].' '.$row['lastname']. "</td>";

	        $result .= "<td>" .$row[3].  "</td>";
	       $result  .=  "<td>". $row[4]. "</td>";
	       $result .= "<td>" .$row[5]. "</td>";
	       $result .= "<td>" .$row[6] ."</td>";
	       $result .="<td>" .$row[7]."</td>";
	        $result .="<td>". $row[8]."</td>";
	        
	       $result .= "</tr>";

       }
       
       return $result;
}


function showLinks(){
			$result = "";
		$result .=  "<a href='admin_home.php'>Home</a> ";
      $result   .=   "<a href='add_customers.php'>Add Customers</a> ";
     $result .= "<a href='view_customers.php'>View Customers</a> ";
     $result .= "<a href='logout.php'>Logout</a> ";

     return $result;



}