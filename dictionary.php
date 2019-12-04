<?php
$pspell_config = pspell_config_create("en");
pspell_config_personal($pspell_config, "/var/dictionaries/custom.pws");
$pspell_link = pspell_new_config($pspell_config);

#pspell_add_to_personal($pspell_link, "meep");
#pspell_add_to_personal($pspell_link, "moop");
#pspell_add_to_personal($pspell_link, "bloop");
#pspell_add_to_personal($pspell_link, "kife");
#pspell_save_wordlist($pspell_link);


/* $word='doublei';
if (pspell_check($pspell_link, $word))
{
	echo "\nspelling is good.\n";
}
else
{
	echo "\nspelling ain't good.\n";
}
 */
?>
