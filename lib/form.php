<?php
class Form
{
	function __construct()
	{
		
	}
	
	public function GenerateForm($hiddens, $postto, $textareas)
	{
		if( !(isset($postto)) )
		{
			throw new Exception ("Post to target not received.");
		}
		if ( strlen($postto) < 5 )
		{
			throw new Exception ("Post to target relative path too small.");
		}			
		$postline;
		$hiddeninputlines=[];
		$textarealines=[];
		$formlines=[];
		foreach ($hiddens as $hiddenname => $hiddenvalue)
		{
			$hiddeninputlines[]="\n        <input type=\"hidden\" name=\"$hiddenname\" value=\"$hiddenvalue\">";	
		}

		foreach ($textareas as $textareainfo => $textareaname)
		{
			$textarealines[]="\n        $textareainfo"."<textarea name=\"".$textareaname."\"></textarea><br>";
		}
		$postline[]="\n    <form method=\"post\" action=\"$postto\">";
		$submitline[]="<br>\n        <input type=\"submit\" value=\"Submit.\">";
		$formlines = array_merge($postline , $hiddeninputlines, $textarealines, $submitline);


		// Could I return a reference instead? If this works I'll see how to do that.
		return $formlines;
	
		
	}
}

?>