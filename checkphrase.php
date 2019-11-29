<!DOCTYPE html>
<html>
<style>
    body
	{
        background-color:#6699ff;
	}
</style>
<body>
<?php
require_once('dbconfig.php');
$postargcount=count($_POST);

if( $postargcount> 0 && $postargcount < 21 ) 
{
	$check_errors='';
	## First type of check... does this match the right letter for the words?
	foreach ($_POST as $letter => $word)
	{
		## unit test - 		$letter = 'P';
		if (strtoupper($word[0]) == $letter )
		{
			echo "    $letter : ".$word."$val is good<br>\n";
		}
		else
		{
			$check_errors.="Check failed for the following (letter, word, word first char, word first char converted to upper case:<br>\n";
			echo "\nDEBUG:<br><br>\n ".$letter . ': ' . $word. ' : ' .$word[0] .' : '. strtoupper($word[0]) . " is bad\n<br>";
		}
	}
	
	if (!$check_errors=='')
	{
		echo "\n<br>No DB operations performed due to check errors on the phrase submission.\n<br>";
	}
	else
	{
		echo "    <br>";

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

			echo "\n    <form method=\"post\" action=\"rank.php\">";
			echo "\n        <input type=\"hidden\" name=\"id\" value=\"$last_id\">";	
			echo "\n        <br>";        
			echo "\n        <br>";        
			echo "\n        <input type=\"submit\" value=\"Proceed.\">";
			echo "\n    </form>"; 		
		}
		else
		{
			echo "    <br>";
			echo "    <br>";
			echo "Attempted to insert a row for the phrase with defaults for the non-phrase values. The following insert was not successful: ";
			echo $query;
		}			
	}
}

?>

    <br>
    <br>
    <a href="dumpdb.php">Dump db</a>
</body>
</html>