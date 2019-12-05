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

$query = "select * from entry;";
echo $query . "<br>";
$result = mysqli_query($link, $query);
while ($obj = mysqli_fetch_object($result))
{
	echo $obj->id." | ".$obj->phrase." | ".$obj->rank." | ".$obj->note."<br>" ;
}

?>

<br>
<br>
<a href="dumpdb.php">Dump db again.</a>

</body>

</html>
