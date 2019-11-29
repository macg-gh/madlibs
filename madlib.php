<!DOCTYPE html>
<html>
<style>
    body
	{
        background-color:#6699ff;
	}
</style>
<body>

<form method="post" action="createtemplate.php" >
	<label for="howmanywords">Number of words (2-20):&nbsp;&nbsp;&nbsp;</label>

<?php
$boxtext = rand(3,20);
echo "    <input type=\"number\" id=\"howmanywords\" name=\"howmanywords\" value=\"$boxtext\" min=\"2\" max=\"20\">\n";
?>
	<br>
	<br>
    <input type="submit" value="Submit word selection.">
</form>
<br>
<br>
<a href="dumpdb.php">Dump db</a>
</body>
</html>