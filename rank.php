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

if (!isset($_POST['rank']) )
{
	echo "<br>";
	echo "Please enter a rank.";
	echo "<form method=\"post\">";
	echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";	
    echo "<br>";
    echo "<br>";            
    echo "<textarea name=\"rank\"></textarea>";
    echo "<br>";            
    echo "<br>";            
    echo "<input type=\"submit\" value=\"Submit rank.\">";
    echo "</form>"; 
    
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
		echo "<form method=\"post\" action=\"note.php\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";	
		echo "<br>";
		echo "<br>";            
		echo "<input type=\"submit\" value=\"Proceed to enter note.\">";
		echo "</form>"; 
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