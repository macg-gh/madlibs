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
#adding this comment ofr the apostrophe branch just going to do it as a commit and merge practice
if(isset($_POST['formtype']))
{
    $formatType = $_POST['formtype'];

	if($formatType == 'createtemplate')
	{
			echo "You have selected this many words: ";
			echo $_POST['howmanywords']."<br>";
			for ( $i = 0 ; $i < $_POST['howmanywords']; $i++ )
			{
				echo "<br>";
				echo chr(rand(65,90))."<br>";
			}
			$i = '';
			echo "<br>";
			echo "Fill in the phrase!";
			echo "<br>";
			echo "<br>";			
			echo "<form method=\"post\">";
			echo "<form method=\"post\">";
			echo "<form method=\"post\">";
			echo "<form method=\"post\">";
			echo "<input type=\"hidden\" name=\"formtype\" value=\"fillinphrase\">";
			echo "Phrase: <textarea name=\"phrase\"></textarea>";
			echo "<br>";
			echo "<br>";			
			echo "Rank: <textarea name=\"rank\"></textarea>";
			echo "<br>";			
			echo "<br>";			
			echo "Note: <textarea name=\"note\"></textarea>";
			echo "<br>";
			echo "<br>";						
			echo "<input type=\"submit\" value=\"Submit Phrase.\">";
			echo "</form>";
	}


	if($formatType == 'fillinphrase')
	{
			$escapedphrase='';
			$escapednote='';
			
			$escapedphrase = mysqli_real_escape_string($link , $_POST['phrase']);
			$escapednote=mysqli_real_escape_string($link , $_POST['note']);
			#This is a defensive escape of rank. There is another check for number below,
			#but if the check for number even malfunctions this escape may still impede an exploit.
			$escapedrank=mysqli_real_escape_string($link , $_POST['rank']);
			
			## Should have some kind of check to see that the rank is a number only.
			## For now if it's not there it gets set to zero.
			if ( !is_numeric( $escapedrank ) )
			{
				echo "Please enter a valid rank value.";
				exit;
			}

			$query = "insert into entry (phrase, rank, note) values(";
			$query .= "'";

			$query .= $escapedphrase;
			$query .= "',";
			$query .= "'";
			$query .= $escapedrank;
			$query .= "',";
			$query .= "'";
			$query .= $escapednote;
			$query .= "'";
			$query .= ");";
			#unit test - $query = "''''''asdfasdfa'''LLL::13218&(&(*U&0";

			if (mysqli_query($link, $query))
			{
				echo "Added to the madlib Collection!";
			}
			else	
			{
				echo "<br>";
				echo "<br>";
				echo "The following query was not successful: ";
				echo $query;
			}
	}
	if($formatType == 'dumpdb')
	{
			$query = "select * from entry;";
			echo $query . "<br>";
			$result = mysqli_query($link, $query);
            while ($obj = mysqli_fetch_object($result))
			{
				echo $obj->id." | ".$obj->phrase." | ".$obj->rank." | ".$obj->note."<br>" ;
			}
    }

		
	
}
else
{
	$boxtext = rand(3,20);
	echo "<form method=\"post\">";
	echo "<input type=\"hidden\" name=\"formtype\" value=\"createtemplate\">";
	echo "How many words? <textarea name=\"howmanywords\">";
	echo $boxtext;
	echo "</textarea>";
	echo "<br>";
	echo "<br>";
	echo "<input type=\"submit\" value=\"Submit word selection.\">";
	echo "</form>";
	
}



?>

<br>
<br>
<form method="post">
    <input type="hidden" name="formtype" value="dumpdb">
    Create Event    <input type="submit" value="DumP current db">
</form> 


</body>

</html>
