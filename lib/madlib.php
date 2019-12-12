<?php
class Madlib
{
	function __construct()
	{
		
	}
	
	public function GenerateLetters($numwords)
	{
		$letters='';
		$i;
		if( !(($numwords > 1) && ($numwords < 21)) )
		{
			throw new Exception("Invalid number of words received: $numwords");
		}
		else
		{
			for( $i=0 ; $i < $numwords ; $i++ )
			{
				// Could use an array, but using just a scalar because this only generates letters.
				$letters.=chr(rand(65,90));
			}
			return $letters;
		}
		
	}
}

?>