<?php
	//Developed by Bilal Ahmad Ghouri
	
	// get rows for query
	function GetRow($qry)
	{
		return mysql_fetch_row($qry);
	}
	//get associative array
	function GetAssoc($qry)
	{
		return mysql_fetch_assoc($qry);
	}
	
	function GetAll($qry)
	{
		$rows = null;
		while($row = mysql_fetch_assoc($qry))
			$rows[] = $row;
		if($rows == null) return array();
		return $rows;
	}
	
	function GetColumnArray($columnArray,$colName)//use for result display (column Name come here iiin second parameter)
	{
		$clmn = array();
		for($i=0; $i<count($columnArray);$i++)
		{
			$clmn[] = $columnArray[$i][$colName];
		}
		return $clmn;
	}
	
	function GetColumnsArray($columnArray,$qry)//registeration aur offerecourses submission (query comes here in second parameter)
	{
		$clmn = array();
		while($row = mysql_fetch_assoc($qry))
			$clmn[] = $row[$columnArray];
		return $clmn;
	}
		
		// delete items from array
	function deleteItems($trg, $src)
	{
		for($i = count($src) - 1; $i >= 0; $i--)
		{
			$pos = array_search($src[$i], $trg);
			unset($trg[$pos]);
		}
		return array_values($trg);
	}
	
	// copy items from array to an array
	function copyItems(&$trg, $src, $fields)
	{
		for($i = count($fields) - 1; $i >= 0; $i--)
		{
			$trg[$fields[$i]] = $src[$fields[$i]];
		}
		return array_values($trg);
	}
	
	function IsEmptySet($qry)
	{
		return mysql_num_rows($qry) == 0;// tells about  the number of record if number == zero return true or false
	}
	
	// get column from table
	function getColumnArrayIf($tbl, $column, $iColumn, $iValue)
	{
		$len = count($tbl) - 1;
		$clmn = array();
		while($len >= 0)
		{	
			if($tbl[$len][$iColumn] == $iValue)
				$clmn[] = $tbl[$len][$column];
			$len--;
		}
		return $clmn;
	}
	
	// gives us day name
	function getDay($num)
	{
		if($num == "0") return "Sunday";
		if($num == "1") return "Monday";
		if($num == "2") return "Tuesday";
		if($num == "3") return "Wednesday";
		if($num == "4") return "Thrusday";
		if($num == "5") return "Friday";
		if($num == "6") return "Saturday";
	}
?>