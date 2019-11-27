<!DOCTYPE html>
<html>
<style>
    body{
        background-color:#6699ff;
}
</style>
<body>
<?php
$howmanywords = $_POST['howmanywords'];
#if ( (is_numeric($howmanywords)) && ( $howmanywords > 0) && ($howmanywords < 21) )
if (is_numeric($howmanywords))	
{
	$letters='';
	echo "You have selected this many words: ";
	echo $_POST['howmanywords']."<br>";
	for ( $i = 0 ; $i < $_POST['howmanywords']; $i++ )
	{
		echo "<br>";
		$char = chr(rand(65,90))."<br>";
		echo $char;
		$letters+=$char;
	}
	$i = ''; 
	echo "<br>";
	echo "Fill in the phrase!";
	echo "<br>";
	echo "<br>";			
	echo "<form method=\"post\" action=\"checkphrase.php\">";
	echo "<input type=\"hidden\" name=\"letters\" value=\"$letters\">";	
	echo "Phrase: <textarea name=\"phrase\"></textarea>";
	echo "<br>";
	echo "<br>";			
	echo "<input type=\"submit\" value=\"Submit Phrase.\">";
	echo "</form>";
}

echo "create template here.";
echo $_POST['howmanywords'];

?>
