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

require_once('./lib/formjson.php');
require_once('./lib/dictionary.php');
require_once('./lib/dbops.php');

$postargcount=count($_POST);

$last_id;

$formjson = new FormJson;
$dictionary = new Dictionary;
$dbops = new DBOps;
$i;

if( $postargcount> 0 && $postargcount < 21 ) 
{
	$letter_errors='';
	$mispelled_words=[];
	$i=0;
	$phrase='';

	foreach ($_POST as $letter => $word)
	{
		if ( strcmp(strtoupper($word[0]),$letter[0]) != 0 )
		{
			echo "    Letter match check failed for the following: $word for letter $letter <br>\n</body>\n</html>";
			exit;
		}
		//// The spelling check and suggestions will only happen if the letter match is good.
		elseif (!($dictionary->SpellCheck($word)))
		{
			$mispelled_words[$i]=$word;		
			$i++;
		}
	}
	
	// Put the mispels in the DB, then correct them if the user decides to do so.
	echo "    <br>";

	//// build phrase, then use default values for rank and for note for now - these will be altered later.
	foreach ($_POST as $word)
	{
		$phrase .= $word." ";
	}
	
	//// default rank of 0, default note of -
	$rowjsondata = '{ "phrase" : "'.$phrase.'" , "rank" : "0" , "note" : "-" }';
	// perform the db insert. Mispelled words will be corrected after if the user chooses to do so.
	try
	{
		$dbops->InsertRow($rowjsondata);
	}
	catch(Exception $e)
	{
		echo "Insert Row operation failed: $e";
		echo "\n</body>";
		echo "\n</html>";
		exit;			
	}
	try
	{
		$last_id = $dbops->GetLastID();
	}
	catch(Exception $e)
	{
		echo "Could not obtain last ID: $e";
		echo "\n</body>";
		echo "\n</html>";
		exit;		
	}	
	
	echo "\n        Mispelled words detected: ".count($mispelled_words)."<br>\n        <br>\n        ";
	echo "If you would like to proceed submitting the words you have entered, click Submit. <br>\n";
	try
	{
		$formdata = '{'."\n".'"postto" : "rank.php",'."\n".'"hiddens" : [{"name" : "id" , "value": "'.$last_id.'" }]'."\n".'}';	
		$formjson->GenerateForm( $formdata);
	}
	catch (Exception $e)
	{
		echo "\n	<br>Generation of proceed without correction form in checkphrase.php was unsuccessful. $e";
		echo "\n</body>";
		echo "\n</html>";
		exit;
	}	
	
	echo "\n        <br>";        			
	echo "\n        <br>";        			

	// For each mispelled word, use the dictionary to get the suggestions. Then generate the form to submit the corrections.
	$formdata='';
	if(count($mispelled_words) != 0)
	{
		echo "\n        Options for word correction are shown below for ".count($mispelled_words)." mispelled words. <br>";			
		
		$formdata = '{'."\n".'"postto" : "corrections.php",'."\n".'"hiddens" : [{"name" : "id" , "value": "'.$last_id.'" }] ,'."\n".'"textareas" : [';
		$i=1;
		$len = count($mispelled_words);
		foreach ($mispelled_words as $mispelled_word)
		{
			$dictionary->SuggestWords($mispelled_word);
			
			if ($i == $len)
			{
				$formdata .= '{ "info" : "correction for '.$mispelled_word.' : " , "name" : "'.$mispelled_word.'"}]'."\n".'}';	
			}
			else
			{
				$formdata .= '{ "info" : "correction for '.$mispelled_word.' : " , "name" : "'.$mispelled_word.'"} ,';	
			}
			$i++;
		}
		try
		{
			$formjson->GenerateForm($formdata);				
		}
		catch (Exception $e)
		{
			echo "\n	<br>Generation of correction form in checkphrase.php was unsuccessful. $e";
		}
	}		

echo "\n</body>";
echo "\n</html>";
	
}

?>
