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
## get the id
$id = $_POST['id'];
unset ($_POST['id']);

## get the phrase
$readphrase = '';
$query = "SELECT * FROM entry WHERE ID='".$id."';";

$result = mysqli_query($link, $query);
$obj = mysqli_fetch_object($result);
$readphrase = $obj->phrase;

echo "\n    <br>read phrase is $readphrase\n    <br>";	

foreach ($_POST as $name => $value)
{
	// replace name(original word) to value(corrected word) in the phrase
	$correctedphrase = str_replace($name , $value , $readphrase);
	
	// read phrase is updated then used for the next iteration.
	$readphrase = $correctedphrase; 
}

echo "\n    <br>corrected phrase is $correctedphrase\n    <br>";

## do the alterations
## this is defensive - shouldn't need it but out of paranoia I'm keeping it.
$escapedcorrectedphrase = mysqli_real_escape_string($link , $correctedphrase);
$query = "UPDATE entry SET phrase='$escapedcorrectedphrase'";
$query .= " WHERE ID = $id;";

if (mysqli_query($link, $query))
{
	echo "\n    <br>Correction has been applied to the phrase\n    <br>";
	// post to rank.php
	echo "\n    <form method=\"post\" action=\"rank.php\">";
	echo "\n        <input type=\"hidden\" name=\"id\" value=\"$id\">";	
	echo "\n        <br>";        
	echo "\n        <br>";        
	echo "\n        <input type=\"submit\" value=\"Proceed to enter rank.\">";
	echo "\n    </form>"; 			
}

?>

    <br>
    <br>
    <a href="dumpdb.php">Dump db</a>
</body>
</html>