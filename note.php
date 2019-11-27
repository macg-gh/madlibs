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
$id = $_POST['id'];

if (!isset($_POST['note']) )
{
	echo "<br>";
	echo "Please enter a note.";
	echo "<form method=\"post\">";
	echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";	
    echo "<br>";
    echo "<br>";            
    echo "<textarea name=\"note\"></textarea>";
    echo "<br>";            
    echo "<br>";            
    echo "<input type=\"submit\" value=\"Submit note.\">";
    echo "</form>"; 	
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
		echo "<a href=\"madlib.php\">Do Another Madlib? Suffer like G did?</a>";
	}
	else
	{
		echo "Attempted to alter the row matching the ID, in order to set the rank. The following statement was not successful: ";
		echo $query;
	}	

}
?>

<br>
<br>
<a href="dumpdb.php">Dump db</a>

</body>

</html>