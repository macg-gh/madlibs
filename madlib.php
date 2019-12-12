<!DOCTYPE html>
<html>
<style>
    body
	{
        background-color:#6699ff;
	}
</style>
<body>
How many words would you like? Minimum 2, Maximum 20.
<br>
<br>

<?php
require_once('./lib/formjson.php');

$randnum = rand(3,20);

$formjson = new FormJson;

$formdata = '{
	"postto" : "createtemplate.php",
	"numberareas" : [{"name" : "howmanywords" , "max": "20" , "min" : "2" ,  "default" : "'.$randnum.'" }]
}';

try
{
	$formjson->GenerateForm( $formdata );

}
catch (Exception $e)
{
	echo "\n	<br>Generation of Form to enter how many words was unsuccessful. $e";
	echo "\n	<br>";
}


?>

</body>
</html>