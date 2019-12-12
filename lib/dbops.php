<?php
class DBOps
{
	public $dblink;
	
	function __construct()
	{
		$this->dblink = mysqli_connect("127.0.0.1", "root", "", "madlibs");
	}

	public function InsertRow($rowdata)
	{
		if ( !($jsondata = json_decode($rowdata, true)) ) 
		{
			throw new Exception ("Json data did not decode successfully.");
		}
		if( !(isset($jsondata['phrase'])) )
		{
			throw new Exception ("Phrase for insert not received.");
		}
		if( !(isset($jsondata['rank'])) )
		{
			throw new Exception ("Rank for insert not received.");
		}
		if( !(isset($jsondata['note'])) )
		{
			throw new Exception ("note for insert not received.");
		}
		if ( strlen($jsondata['phrase']) < 3 )
		{
			throw new Exception ("Phrase length too small.");
		}	 
 		$phrase=mysqli_real_escape_string($this->dblink, $jsondata['phrase']);
		$rank=mysqli_real_escape_string($this->dblink, $jsondata['rank']);
		$note=mysqli_real_escape_string($this->dblink, $jsondata['note']);
		
		$query = "insert into entry (phrase, rank, note) values('".$phrase."','".$rank."','".$note."');";

		if (mysqli_query($this->dblink, $query))
		{
			echo "\n<br> Row Inserted \n<br>";
		}
		else
		{
			throw new Exception ("\n<br>Unable to insert row when trying query: $query\n<br>");
		}
	}
	
	public function GetLastID()
	{
		$last_id = mysqli_insert_id($this->dblink);	
		return $last_id;
	}
	
	public function UpdateRow($rowdata)
	{
		if ( !($jsondata = json_decode($rowdata, true)) ) 
		{
			throw new Exception ("Json data did not decode successfully.");
		}		
		if( !(isset($jsondata['target'])) )
		{
			throw new Exception ("Target for update not received.");
		}		
		if ( strlen($jsondata['target']) < 1 )
		{
			throw new Exception ("Target can't be blank.");
		}	 
		if( !(isset($jsondata['value'])) )
		{
			throw new Exception ("Value for update not received.");
		}
		if ( strlen($jsondata['value']) < 1 )
		{
			throw new Exception ("Value can't be blank.");
		}
		if( !(isset($jsondata['id'])) )
		{
			throw new Exception ("ID for row to update not received.");
		}
		if( !(is_numeric($jsondata['id'])) )
		{
			throw new Exception ("ID for row to update not numeric.");
		}
		
		$target=mysqli_real_escape_string($this->dblink, $jsondata['target']);
		$value=mysqli_real_escape_string($this->dblink, $jsondata['value']);
		$id=mysqli_real_escape_string($this->dblink, $jsondata['id']);
		$query = "UPDATE entry SET $target ='$value' WHERE ID = '$id';";
		$result = mysqli_query($this->dblink , $query);
		return $result;
	}
	
	public function GetPhrase($id)
	{
		if( !(isset($id)) )
		{
			throw new Exception ("ID for obtaining phrase not received.");
		}
		$query = "SELECT * FROM entry WHERE ID='".$id."';";
		$result = mysqli_query($this->dblink, $query);
		$obj = mysqli_fetch_object($result);
		return ($obj->phrase);
	}
}

?>