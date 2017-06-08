

<?php

$db = mysqli_connect ("localhost","root","","online_banking") or die(msqli_error($db));

function authenticate ()
		{

				if(!isset($_SESSION['id'])  && !isset($_SESSION['admin_name'])){






					header("Location: admin_login.php");
				} 


		}

 ?>

