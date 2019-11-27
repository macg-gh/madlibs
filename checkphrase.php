<!DOCTYPE html>
<html>
<style>
    body{
        background-color:#6699ff;
}
</style>
<body>
<?php
require_once('dbconfig.php');

if( isset($_POST['phrase']) && (isset($_POST['letters'])) )
{
    #assuming the phrase is good - have not yet checked it against the template.
	$phrase = mysqli_real_escape_string($link , $_POST['phrase']);
    echo "Phrase: $phrase";
	echo "<br>";
	echo "<br>";
	echo "Phrase is good!";
	echo "<br>";

	## non-conditional insert of the phrase and then get the ID to pass it forward - will change.
	## uses default values for rank and for note.
	$query = "insert into entry (phrase, rank, note) values(";
	$query .= "'";
	$query .= $phrase;
	$query .= "',";
	$query .= "'";
	## default rank of 0 for now.
	$query .= "0"; 
	$query .= "',";
	$query .= "'";
	## default note of - for now.
	$query .= "-";
	$query .= "'";
	$query .= ");";
	// unit test - // $query = "''''''asdfasdfa'''LLL::13218&(&(*U&0";

	if (mysqli_query($link, $query))
	{
		## GET THE ID.
		$last_id = mysqli_insert_id($link);			

		echo "<form method=\"post\" action=\"rank.php\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"$last_id\">";	
		echo "<br>";        
		echo "<br>";            
		echo "<input type=\"submit\" value=\"Proceed.\">";
		echo "</form>"; 		
	}
	else
	{
		echo "<br>";
		echo "<br>";
		echo "Attempted to insert a row for the phrase with defaults for the other values. The following insert was not successful: ";
		echo $query;
	}	
}

?>

<br>
<br>
<a href="dumpdb.php">Dump db</a>

</body>

</html>