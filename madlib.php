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

$i = '';

if(isset($_POST['formtype']))
{
    $formatType = $_POST['formtype'];

	if($formatType == 'createrandomnumber')
	{
			echo "You have selected this many words: ";
			echo $_POST['howmanywords']."<br>";
			for ( $i = 0 ; $i < $_POST['howmanywords']; $i++ )
			{
				echo "<br>";
				echo chr(rand(65,90))."<br>";
			}
			$i = '';
			echo "Fill in the phrase!";

	}
	if($formatType == 'fillinphrase')
	{
			$rank = 0;
			## Should have some kind of check to see that the rank is a number only.
			if ($_POST['rank'])
			{
				$rank = $_POST['rank'];
			}			
			echo $_POST['phrase'];
			$query = "insert into entry (phrase, rank, note) values(";
			$query .= "'";
			$query .= $_POST['phrase'];
			#$query .= "some default testing name";
			$query .= "',";
			$query .= "'";
			$query .= $rank;
			$query .= "',";
			$query .= "'";
			$query .= $_POST['note'];
			$query .= "'";
			$query .= ");";
			echo $query;
			mysqli_query($link, $query);
	}
	if($formatType == 'dumpdb')
	{
			$query = "select * from entry;";
			echo $query . "<br>";
			$result = mysqli_query($link, $query);
            while ($obj = mysqli_fetch_object($result))
			{
                #printf ("%s (%s)\n", $obj->Name, $obj->CountryCode);
				echo $obj->id." | ".$obj->phrase." | ".$obj->rank." | ".$obj->note."<br>" ;
			}
    }


		
	
}



?>
<form method="post">
    <input type="hidden" name="formtype" value="createrandomnumber">
	How many words? <textarea name="howmanywords"><?php echo rand(3,20) ?></textarea>
	<input type="submit" value="Submit word selection.">
</form>

<form method="post">
    <input type="hidden" name="formtype" value="fillinphrase">
	Phrase: <textarea name="phrase"></textarea>
	Rank: <textarea name="rank"></textarea>
	Note: <textarea name="note"></textarea>
	<input type="submit" value="Submit Phrase.">
</form>

<form method="post">
    <input type="hidden" name="formtype" value="dumpdb">
    Create Event    <input type="submit" value="DumP current db">
</form>


</body>

</html>
