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
// foreach ($_POST as $name => $value){ echo "$name $value\n"; } // exit;
$last_id;
if( $postargcount> 0 && $postargcount < 21 ) 
{
	$letter_errors='';
	$mispelled_words;
	$i=0;

	foreach ($_POST as $letter => $word)
	{
		// unit test - 		$letter = 'P';
		if ( strcmp(strtoupper($word[0]),$letter[0]) != 0 )
		{
			$letter_errors.="    Letter match check failed for the following: $word for letter $letter <br>\n";
		}
		//// only do the spelling check and suggestions if the letter match is good.
		elseif (!pspell_check($pspell_link, $word))
		{
			
			$mispelled_words[$i]=$word;
			// echo "\n word: ".$word."\n\n";						
			// echo "\nmispelled words i: ".$mispelled_words[$i]."\n\n";
			// echo "\n i: ".$i."\n\n";			
			$i++;
		}
	}
	
	if (!$letter_errors=='')
	{
		echo "\n    <br>No DB operations performed due to letter mismatches on the phrase submission.\n    <br>$letter_errors\n    <br>";
	}
	// if the letters are OK, put the mispels in the DB, then check if corrections are needed.
	else
	{
		echo "    <br>";

		//// build phrase, then use default values for rank and for note for now - these will be altered later.
		foreach ($_POST as $word)
		{
			$phrase .= $word." ";
		}
		$query = "insert into entry (phrase, rank, note) values(";
		$query .= "'";
		$query .= $phrase;
		$query .= "',";
		$query .= "'";
		//// default rank of 0 for now.
		$query .= "0"; 
		$query .= "',";
		$query .= "'";
		//// default note of - for now.
		$query .= "-";
		$query .= "'";
		$query .= ");";
		// unit test - // $query = "''''''asdfasdfa'''LLL::13218&(&(*U&0";

		if (mysqli_query($link, $query))
		{
			echo "\n\n<br><br> query succesful, it was: $query \n\n<br><br>";
			//// GET THE ID.
			$last_id = mysqli_insert_id($link);			

			echo "\n    <form method=\"post\" action=\"rank.php\">";
			echo "\n        <input type=\"hidden\" name=\"id\" value=\"$last_id\">";	
			echo "\n        <br>";        
			echo "\n        <br>";        
			echo "\n        Mispelled words detected: ".count($mispelled_words)."<br>"."If you would like to proceed submitting the words you have entered, click Proceed. <br>";
			echo "\n        <br>";        						
			echo "\n        <input type=\"submit\" value=\"Proceed.\">";			
			echo "\n    </form>"; 		
			echo "\n        <br>";        
			echo "\n        <br>";        			
			echo "\n        Options for word correction are shown below for ".count($mispelled_words)." mispelled words. <br>";			
		}
		else
		{
			echo "    <br>";
			echo "    <br>";
			echo "Attempted to insert a row for the phrase with defaults for the non-phrase values. The following insert was not successful: ";
			echo $query;
		}			

		//// Check for mispels which will be corrected if necessary.
		//   echo "\ncount of mispelled words ".count($mispelled_words);
		if (count($mispelled_words)!=0)
		{
			echo "\n    <form method=\"post\" action=\"corrections.php\">";
			
			foreach ($mispelled_words as $mispelled_word)
			{
				
				echo "    Possible spelling:<br>\n";
				$suggestions = pspell_suggest ( $pspell_link , $mispelled_word );
				foreach ($suggestions as $suggestion)
				{
					echo "    $suggestion<br>\n";
				}
				echo "\n    Enter correction for word $mispelled_word\n<br>";				
				echo "\n    <textarea name=\"$mispelled_word\"></textarea>";
				echo "\n        <br>";        			
				echo "\n        <br>";    				
			}
			echo "\n        <input type=\"hidden\" name=\"id\" value=\"$last_id\">";	
			echo "\n        <input type=\"submit\" value=\"Submit corrections.\">";
			echo "\n    </form>"; 
			echo "\n    Still need a new piece here to say save the word instead.\n<br>";
			
		}
	}	
}

?>

    <br>
    <br>
    <a href="dumpdb.php">Dump db</a>
</body>
</html>