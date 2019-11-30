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
require_once('dictionary.php');

$postargcount=count($_POST);

if( $postargcount> 0 && $postargcount < 21 ) 
{
	$check_errors='';
	## First type of check... does this match the right letter for the words?
	foreach ($_POST as $letter => $word)
	{
		## unit test - 		$letter = 'P';
		if ( strcmp(strtoupper($word[0]),$letter) != 0 )
		{
			$check_errors.="    Letter match check failed for the following: $word $letter <br>\n";
		}
		
		if (!pspell_check($pspell_link, $word))
		{
			$check_errors.="    Spelling (dictionary) check failed for word: $word , letter was $letter <br>\n";
		}
	}
	
	if (!$check_errors=='')
	{
		echo "\n    <br>No DB operations performed due to check errors on the phrase submission.\n    <br>errors encountered:\n    <br>$check_errors\n    <br>";
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