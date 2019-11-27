<!DOCTYPE html>
<html>
<style>
    body{
        background-color:#6699ff;
}
</style>
<body>
<?php

$boxtext = rand(3,20);
echo "<form method=\"post\" action=\"createtemplate.php\" >";
echo "\n";  
echo "\n";
echo "    How many words?";
echo "\n";  
echo "    <textarea name=\"howmanywords\">";
echo "\n";
echo $boxtext;
echo "\n";  
echo "    </textarea>";
echo "<br>";
echo "<br>";
echo "\n";  
echo "    <input type=\"submit\" value=\"Submit word selection.\">";
echo "\n";      
echo "    </form>";

?>

<br>
<br>
<a href="dumpdb.php">Dump db</a>

</body>

</html>