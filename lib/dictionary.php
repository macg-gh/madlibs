<?php
class Dictionary
{
	public $pspell_config;
	public $pspell_link;
	
	function __construct()
	{
		$this->pspell_config = pspell_config_create("en");
		pspell_config_personal($this->pspell_config, "/var/dictionaries/custom.pws");
		$this->pspell_link = pspell_new_config($this->pspell_config);		
	}

	function SuggestWords($mispelled_word)
	{
 		if( !(isset($mispelled_word)) )
		{
			throw new Exception ("Mispelled word not received.");
		}
		
		echo "    Mispelled word $mispelled_word - Possible spelling:<br>\n";
		$suggestions = pspell_suggest ( $this->pspell_link , $mispelled_word );
		foreach ($suggestions as $suggestion)
		{
			echo "    $suggestion<br>\n";
		}
	}
	
	function Spellcheck($word)
	{
		return pspell_check($this->pspell_link, $word);
	}
}

?>