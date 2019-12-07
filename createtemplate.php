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
require_once('./lib/form.php');

$e;
$madlib = new Madlib;
try
{
	$letters = $madlib->GenerateLetters($_POST['howmanywords']);
}
catch(Exception $e)
{
	echo "\n	<br>Generation of letters was unsuccessful.";
	echo "\n	<br>";
	echo "\n</body>";
	echo "\n</html>";
	exit;	
}

echo "    You have selected this many words:&nbsp;";
echo $_POST['howmanywords'];
echo "\n    <br>";

$form = new Form;
$textareaattrs;

for ( $i = 0 ; $i <strlen($letters) ; $i++)
{
	$textareainfo=$letters[$i]." : ";
	$textareaname=$letters[$i]."_".$i;
	$textareaattrs[$textareainfo]=$textareaname;
}

try
{
	$returnlines=$form->GenerateForm( "" , "checkphrase.php" , $textareaattrs );
}
catch (Exception $f)
{
	echo "\n	<br>Generation of Form was unsuccessful.$f";
	echo "\n	<br>";
	echo "\n</body>";
	echo "\n</html>";
	exit;		
}

foreach ($returnlines as $testreturnline)
{
	echo $testreturnline;
}

echo "</form>";
echo "\n	<br>";
echo "\n	<br>";	
echo "\n</body>";
echo "\n</html>";

?>

