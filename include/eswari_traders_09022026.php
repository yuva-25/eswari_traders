<?php
	class db
	{
		public $con;	
		// public $db_name = "sriseosolutions_subha2025";
		public $db_name = "eswari_traders_09022026";
		

		public function connect() {			
			$servername = "localhost";
			// $username = "sriseosolutions_subha2025";
            // $password = "TI8y[W360]^_";
			$username = "root";
			$password = "";				
			try {
			  $con = new PDO("mysql:host=$servername;dbname=".$this->db_name.";charset=utf8", $username, $password);
			  // set the PDO error mode to exception
			  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  return $con;
			} 
			catch(PDOException $e) {
			  echo "Connection failed: " . $e->getMessage();
			}
			
		}	
	}
?>