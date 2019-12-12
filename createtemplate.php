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
require_once('./lib/madlib.php');
require_once('./lib/formjson.php');

$e;
$madlib = new Madlib;
try
{
	$letters = $madlib->GenerateLetters($_POST['howmanywords']);
}
catch(Exception $e)
{
	echo "\n	<br>Generation of letters was unsuccessful: $e";
	echo "\n</body>";
	echo "\n</html>";
	exit;	
}

echo "    You have selected this many words:&nbsp;";
echo $_POST['howmanywords'];
echo "\n    <br>";
echo "\n    <br>";

$formjson = new FormJson;

$formdata = "{
	\"postto\": \"checkphrase.php\",
	\"textareas\" : [{\"info\" : \"$letters[0] : \" , \"name\" : \"$letters[0]_0\" } ";
	
for ( $i = 1 ; $i < strlen($letters) ; $i++ )
{
	$formdata.=", {\"info\" : \"".$letters[$i]." : \" , \"name\" : \"".$letters[$i].'_'.$i."\"   } ";
}

$formdata .= "]\n}";

try
{
	$formjson->GenerateForm( $formdata );
}
catch (Exception $f)
{
	echo "\n	<br>Generation of Form was unsuccessful.$f";
	echo "\n	<br>";
}

echo "\n</body>";
echo "\n</html>";

?>

