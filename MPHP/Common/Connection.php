<?php
	// By Bilal Ahmad
	//-----------------------------------------
	// This class provides connection and basic to our database
	class Connection
	{
		private $con;	// Connection 
		private $qry;	// Query result
		
		// Connect to database
		public function Start()
		{
			ob_start();	 // Start session
			$this->con = mysql_connect("localhost", "root", "");
			//$this->con = mysql_connect("whoelect.com", "whoelect_user", "12345kichasher");
			if (!$this->con)	// check success	
				throw new Exception("Unable to connect.");
			//mysql_select_db("whoelect_test", $this->con); // selecting database
			mysql_select_db("msis", $this->con); // selecting database
		}
		// perform query and return success
		public function Query($cmd)
		{
			$this->qry = mysql_query($cmd, $this->con);	
			if ($this->qry === false) 
				throw new Exception("Error in Query " . $cmd);
		}
		// get rows for query
		public function GetRow()
		{
			return mysql_fetch_row($this->qry);
		}
		//get associative array
		public function GetAssoc()
		{
			return mysql_fetch_assoc($this->qry);
		}
		// close connection
		public function Terminate()
		{
			mysql_close($this->con);
			ob_end_flush();	
		}
		// Try query without saving result in class
		public function QueryWS($cmd)
		{
			$res = mysql_query($cmd, $this->con);	
			if ($res === false) 
				throw new Exception("Error in Query " . $cmd);
		}
		// Get Effected rows 
		public function GetRowsEffected()
		{
			return mysql_affected_rows($this->con);
		}
		public function IsEmptySet()
		{
			return mysql_num_rows($this->qry) == 0;
		}
		public function GetAll()
		{
			$rows = null;
			while($row = mysql_fetch_assoc($this->qry))
				$rows[] = $row;
			if($rows == null) return array();
			return $rows;
		}
		public function GetColumnArray($columnArray)
		{
			$clmn = array();
			while($row = mysql_fetch_assoc($this->qry))
				$clmn[] = $row[$columnArray];
			return $clmn;
		}
		public function GetID()
		{
			return mysql_insert_id($this->con);
		}
	}

?>