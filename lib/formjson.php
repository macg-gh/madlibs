<?php
class FormJson
{
	function __construct()
	{
	}

	public function GenerateForm($formdata)
	{
		if ( !($jsondata = json_decode($formdata, true)) ) // decode the JSON data
		{
			throw new Exception ("Json data did not decode successfully.");
		}
 		if( !(isset($jsondata['postto'])) )
		{
			throw new Exception ("Post to target not received.");
		}
		if ( strlen($jsondata['postto']) < 5 )
		{
			throw new Exception ("Post to target relative path too small.");
		}	 
		
		// generate the post to line
		echo ("\n    <form method=\"post\" action=\"".$jsondata['postto']."\">");
		if (isset ($jsondata['hiddens']))
		{
			foreach ($jsondata['hiddens'] as $hid)
			{
				echo ("\n        <input type=\"hidden\" name=\"".$hid['name']."\" value=\"".$hid['value']."\">");
			}
		}

		if (isset ($jsondata['textareas']))
		{	
			foreach ($jsondata['textareas'] as $ta)
			{
				echo ("\n        ".$ta['info']."<textarea name=\"".$ta['name']."\"></textarea><br>");
			}
		}
		
		if (isset ($jsondata['numberareas']))
		{
			foreach ($jsondata['numberareas'] as $na)
			{ 
				echo("\n    <input type=\"number\" name=\"".$na['name']."\" value=\"".$na['default']."\" min=\"".$na['min']."\" max=\"".$na['max']."\">");
			}	
		}
		echo "\n	    <br>";
		echo "\n	    <br>";		
		echo "\n        <input type=\"submit\" value=\"Submit.\">";
		echo "\n	    </form>";		
	}
}

?>