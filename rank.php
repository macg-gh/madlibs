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

if (!isset($_POST['rank']) )
{
	echo "Please enter a rank.";
    echo "<br>";
    echo "<br>";            

	$formdata = '{
		"postto" : "rank.php",
		"numberareas" : [{"name" : "rank" , "max": "1000" , "min" : "0" ,  "default" : "30" }] ,
		"hiddens" : [{ "name" : "id" , "value" : "'.$id.'"  }]
	}';	
	try{
		$formjson->GenerateForm($formdata);
	}
	catch(Exception $e){
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

	## this is defensive - shouldn't need it if it's already been blessed as numeric.
	$rank = mysqli_real_escape_string($link , $_POST['rank']);
	$query = "UPDATE entry SET RANK='$rank'";
	$query .= " WHERE ID = $id;";
	
	if (mysqli_query($link, $query))
	{
		echo "Rank updated.";

		$formdata = '{
			"postto" : "note.php",
			"hiddens" : [{ "name" : "id" , "value" : "'.$id.'"  }]
		}';	
		try{
			$formjson->GenerateForm($formdata);
		}
		catch(Exception $e){
			echo "Generate form for starting note addition did not work: $e";
		}	
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

