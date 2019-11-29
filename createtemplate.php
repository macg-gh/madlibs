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
$howmanywords = $_POST['howmanywords'];
if ( (is_numeric($howmanywords)) && ( $howmanywords > 0) && ($howmanywords < 21) )
{
	echo "    You have selected this many words:&nbsp;";
	echo $_POST['howmanywords'];
	echo "\n    <br>";
	echo "\n    <form method=\"post\" action=\"checkphrase.php\">";
	for ( $i = 0 ; $i < $_POST['howmanywords']; $i++ )
	{
		echo "\n    <br>";
		$char = chr(rand(65,90));
		echo $char;
		echo " :&nbsp;&nbsp;<textarea name=\"$char\"></textarea>";
		echo "\n    <br>";
		echo "\n    <br>";
		#echo "$i";
	}
	$i = ''; 

	echo "Fill in the phrase!";
	echo "\n    <br>";
	echo "\n    <br>";
	echo "\n        <input type=\"submit\" value=\"Submit Phrase.\">";
}

?>

    </form>
	<br>
	<br>
	<a href="dumpdb.php">Dump db</a>
</body>
</html>