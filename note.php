<!DOCTYPE html>
<html>
<style>
    body{
        background-color:#6699ff;
}
</style>
<body>
<?php
require_once('dbconfig.php');
require_once('./lib/formjson.php');

$id = $_POST['id'];

$formjson = new FormJson;

if (!isset($_POST['note']) )
{
	echo "<br>";	
	$formdata = '{
		"postto" : "note.php",
		"textareas" : [{"info" : "Please enter a note : " , "name": "note" }] ,
		"hiddens" : [{ "name" : "id" , "value" : "'.$id.'"  }]
	}';	
	try{
		$formjson->GenerateForm($formdata);
	}
	catch(Exception $e){
		echo "Generate form for note submitting did not work: $e";
		echo "Generate form for rank submitting did not work: $e";
		echo "\n</body>";
		echo "\n</html>";
		exit;			
	}	
}	
elseif ((is_numeric($id)) && ( $id > 0) )
{
	echo "ID received: $id";
	echo "<br>";            
	echo "<br>";            

	## this is defensive - don't want unescaped text
	$note = mysqli_real_escape_string($link , $_POST['note']);
	$query = "UPDATE entry SET NOTE='$note'";
	$query .= " WHERE ID = $id;";
	
	if (mysqli_query($link, $query))
	{
		echo "Note updated.";
		echo "<br>";
		echo "<br>";
		echo "Madlib fully entered!.";
		echo "<br>";
		echo "<br>";
		echo "<a href=\"madlib.php\">Do Another Madlib?</a>";
	}
	else
	{
		echo "Attempted to alter the row matching the ID, in order to set the rank. The following statement was not successful: ";
		echo $query;
	}	

}

echo "\n</body>";
echo "\n</html>";
?>
