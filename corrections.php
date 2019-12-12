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

require_once('./lib/dbops.php');
require_once('./lib/formjson.php');

$dbops = new DBops;
$formjson = new FormJson;
// get the id
$id = $_POST['id'];
unset ($_POST['id']);

$readphrase;
// get the phrase
try
{
	$readphrase=$dbops->GetPhrase($id);
}
catch(Exception $e)
{
	echo "Could not get the phrase which will be corrected: $e";
	echo "\n</body>";
	echo "\n</html>";
	exit;	
}

echo "\n    <br>read phrase is $readphrase\n    <br>";	

foreach ($_POST as $name => $value)
{
	// replace name(original word) to value(corrected word) in the phrase
	$correctedphrase = str_replace($name , $value , $readphrase);
	
	// read phrase is updated then used for the next iteration.
	$readphrase = $correctedphrase; 
}

echo "\n    <br>corrected phrase is $correctedphrase\n    <br>";

## do the update - This time, with CLASS
try
{
	$rowdata='{"target" : "phrase" , "value" : "'.$correctedphrase.'" , "id" : "'.$id.'"}';
	$dbops->UpdateRow($rowdata);
}
catch(Exception $e)
{
	echo "Could not update the row with id $id: $e";
	echo "\n</body>";
	echo "\n</html>";
	exit;	
}

echo "\n    <br>Correction has been applied to the phrase\n    <br>";

try
{
	$formdata='{ "postto" : "rank.php" , "hiddens" : [ { "name" : "id" , "value" : "'.$id.'"} ] }';
	$formjson->GenerateForm($formdata);
}
catch (Exception $e)
{
	echo "Could not generate form for rank.php: $e";

}
echo "\n</body>";
echo "\n</html>";

?>