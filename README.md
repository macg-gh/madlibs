# madlibs
A little game that runs on a LAMP stack

Platform Requirements:

Mysql version:
mysql  Ver 14.14 Distrib 5.7.27, for Linux (x86_64) using  EditLine wrapper

Apache version:
Apache/2.4.29 

PHP version:
PHP 7.2.24-0ubuntu0.18.04.1

To deploy:

1 - Change the auth strategy for mysql.
Start mysql with just 'mysql' and no other options. The changes we're about to make will make a password mandatory.
Run the following command in mysql: ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '<YOUR PASSWORD>';
  
The password value used will be the root password of mysql, and will be required for logins from this point forward.

2 - Run dbcreate.sql
You can paste the command into the msyql prompt after doing step 1.
Or, you can run this with the following command: source database.sql

Note - you may have to include the path to this file depending on where it is located.

3 - Update apt and install necessary parts of pspell

apt update

apt upgrade - install package maintainer’s version when prompted

apt install g++

apt install aspell

apt install php7.2-pspell

php -a

$psspell_link= pspell_new_personal ("/var/dictionaries/custom.pws","en","","","",PSPELL_FAST|PSPELL_RUN_TOGETHER );

This should not emit "Uncaught Error: Call to undefined function pspell_new_personal() in php shell code", instead it should allow you to enter that line and move on to the next prompt where you can enter a line. Type 'exit' then hit enter to stop.

4 - service apache2 restart

5 - Place the following files into /var/www/html/
checkphrase.php
corrections.php
createtemplate.php
dbconfig.php
dictionary.php
dumpdb.php
madlib.php
note.php
rank.php

6 - Edit dbconfig.php to use the password set in step 1. Enter it for the 3rd parameter to the mysql_connect function.

Once these steps are complete, you should be able to start generating madlibs and saving the result.
