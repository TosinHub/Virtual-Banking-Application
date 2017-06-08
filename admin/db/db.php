<?php 
# test.php sandbox

class Database{
	 private $host = "localhost";
   	 private $db_name = "bookstore";
   	 private $username = "root";
   	 private $password = "papa2657";
     

		public function dbConnection(){

					$db = mysqli_connect ("$this->host","$this->username","$this->password","$this->db_name")

				}


		}